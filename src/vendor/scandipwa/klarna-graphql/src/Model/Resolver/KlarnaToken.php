<?php
/**
 * ScandiPWA - Progressive Web App for Magento
 *
 * Copyright © Scandiweb, Inc. All rights reserved.
 * See LICENSE for license details.
 *
 * @license OSL-3.0 (Open Software License ("OSL") v. 3.0)
 * @package scandipwa/quote-graphql
 * @link    https://github.com/scandipwa/quote-graphql
 */
declare(strict_types=1);

namespace ScandiPWA\KlarnaGraphQl\Model\Resolver;

use Klarna\Core\Api\BuilderInterface;
use Klarna\Core\Exception;
use Klarna\Kp\Api\CreditApiInterface;
use Klarna\Kp\Api\Data\ResponseInterface;
use Klarna\Kp\Api\QuoteInterface;
use Klarna\Kp\Api\QuoteRepositoryInterface;
use Klarna\Kp\Model\QuoteFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Phrase;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\GuestCartRepositoryInterface;
use Magento\Webapi\Controller\Rest\ParamOverriderCustomerId;

class KlarnaToken implements ResolverInterface
{
    /**
     * @var CreditApiInterface
     */
    protected $api;

    /**
     * @var BuilderInterface
     */
    protected $builder;

    /**
     * @var QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @var CartManagementInterface
     */
    protected $quoteManagement;

    /**
     * @var QuoteRepositoryInterface
     */
    protected $kQuoteRepository;

    /**
     * @var ParamOverriderCustomerId
     */
    protected $overriderCustomerId;

    /**
     * @var GuestCartRepositoryInterface
     */
    protected $guestCartRepository;

    /**
     * @param GuestCartRepositoryInterface $guestCartRepository
     * @param ParamOverriderCustomerId $overriderCustomerId
     * @param QuoteRepositoryInterface $kQuoteRepository
     * @param BuilderInterface $builder
     * @param QuoteFactory $quoteFactory
     * @param CartManagementInterface $quoteManagement
     * @param CreditApiInterface $api
     */
    public function __construct(
        GuestCartRepositoryInterface $guestCartRepository,
        ParamOverriderCustomerId $overriderCustomerId,
        QuoteRepositoryInterface $kQuoteRepository,
        BuilderInterface $builder,
        QuoteFactory $quoteFactory,
        CartManagementInterface $quoteManagement,
        CreditApiInterface $api
    ) {
        $this->api = $api;
        $this->builder = $builder;
        $this->quoteFactory = $quoteFactory;
        $this->quoteManagement = $quoteManagement;
        $this->kQuoteRepository = $kQuoteRepository;
        $this->overriderCustomerId = $overriderCustomerId;
        $this->guestCartRepository = $guestCartRepository;
    }

    /**
     * @inheritDoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ) {
        $cart = $this->getCart($args['input']);
        $data = $this->getGeneratedCreateRequest($cart);
        $klarnaResponse = $this->api->createSession($data);
        $this->generateKlarnaQuote($klarnaResponse, $cart);

        return $klarnaResponse->getClientToken();
    }

    /**
     * Generates Klarna quote
     *
     * @param ResponseInterface $klarnaResponse
     * @param CartInterface $cart
     * @return QuoteInterface
     * @throws GraphQlInputException
     */
    protected function generateKlarnaQuote(ResponseInterface $klarnaResponse, CartInterface $cart): QuoteInterface
    {
        try {
            $klarnaQuote = $this->kQuoteRepository->getActiveByQuote($cart);
            $klarnaQuote->setSessionId($klarnaResponse->getSessionId());
            $klarnaQuote->setClientToken($klarnaResponse->getClientToken());
            $klarnaQuote->setPaymentMethods(
                $this->extractPaymentMethods($klarnaResponse->getPaymentMethodCategories())
            );
            $klarnaQuote->setPaymentMethodInfo($klarnaResponse->getPaymentMethodCategories());
            $this->kQuoteRepository->save($klarnaQuote);
            return $klarnaQuote;
        } catch (NoSuchEntityException $e) {
            return $this->createNewQuote($klarnaResponse, $cart);
        }
    }

    /**
     * Creates new Klarna Quote
     *
     * @param ResponseInterface $klarnaResponse
     * @param CartInterface $cart
     * @return QuoteInterface
     * @throws GraphQlInputException
     */
    protected function createNewQuote(ResponseInterface $klarnaResponse, CartInterface $cart): QuoteInterface
    {
        if (!$cart->getId()) {
            throw new GraphQlInputException(new Phrase('Unable to initialize Klarna payments session'));
        }

        /** @var QuoteInterface $klarnaQuote */
        $klarnaQuote = $this->quoteFactory->create();
        $klarnaQuote->setSessionId($klarnaResponse->getSessionId());
        $klarnaQuote->setClientToken($klarnaResponse->getClientToken());
        $klarnaQuote->setIsActive(1);
        $klarnaQuote->setQuoteId($cart->getId());
        $klarnaQuote->setPaymentMethods(
            $this->extractPaymentMethods($klarnaResponse->getPaymentMethodCategories())
        );
        $klarnaQuote->setPaymentMethodInfo($klarnaResponse->getPaymentMethodCategories());
        $this->kQuoteRepository->save($klarnaQuote);
        return $klarnaQuote;
    }

    /**
     * @param $categories
     * @return mixed
     */
    private function extractPaymentMethods($categories)
    {
        $payment_methods = [];
        foreach ($categories as $category) {
            $payment_methods[] = 'klarna_' . $category['identifier'];
        }
        return implode(',', $payment_methods);
    }

    /**
     * @param CartInterface $cart
     * @return array
     * @throws Exception
     */
    protected function getGeneratedCreateRequest(CartInterface $cart)
    {
        $cart->collectTotals();
        return $this->builder->setObject($cart)->generateRequest(BuilderInterface::GENERATE_TYPE_CREATE)
            ->getRequest();
    }

    /**
     * Retrieves M2 Cart
     *
     * @param array $input
     * @return CartInterface
     * @throws GraphQlInputException
     */
    protected function getCart(array $input = []): CartInterface
    {
        $cart = array_key_exists('guest_cart_id', $input)
            ? $this->getCartForGuest($input['guest_cart_id'])
            : $this->getCartForLoggedInUser();

        // We check cartId in case magento initializes new cart, if it is not found
        $cartId = $cart->getId();
        if ($cartId === null) {
            throw new GraphQlInputException(__("Unable to retrieve cart, cart ID is null"));
        }

        return $cart;
    }

    /**
     * @param string $guestCartId
     * @return CartInterface
     * @throws GraphQlInputException
     */
    private function getCartForGuest(string $guestCartId)
    {
        try {
            return $this->guestCartRepository->get($guestCartId);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlInputException(__("Unable to retrieve cart. guestCardId is invalid"));
        }
    }

    /**
     * @return CartInterface
     * @throws GraphQlInputException
     */
    private function getCartForLoggedInUser()
    {
        try {
            return $this->quoteManagement->getCartForCustomer(
                $this->overriderCustomerId->getOverriddenValue()
            );
        } catch (NoSuchEntityException $e) {
            throw new GraphQlInputException(__("Unable to retrieve cart for logged in user"));
        }
    }
}
