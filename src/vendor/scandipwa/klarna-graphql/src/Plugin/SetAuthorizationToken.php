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

namespace ScandiPWA\KlarnaGraphQl\Plugin;

use Klarna\Core\Helper\ConfigHelper;
use Klarna\Kp\Api\QuoteInterface;
use Klarna\Kp\Api\QuoteRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\QuoteGraphQl\Model\Cart\SetPaymentMethodOnCart;
use Magento\Quote\Model\Quote;
use Psr\Log\LoggerInterface;

/**
 * Plugin that assigns authorization token to Klarna Quote
 */
class SetAuthorizationToken
{
    const KLARNA_TITLE = 'Klarna';

    /**
     * @var QuoteRepositoryInterface
     */
    private $klarnaQuoteRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     * @param QuoteRepositoryInterface $klarnaQuoteRepository
     */
    public function __construct(
        LoggerInterface $logger,
        QuoteRepositoryInterface $klarnaQuoteRepository
    ) {
        $this->logger = $logger;
        $this->klarnaQuoteRepository = $klarnaQuoteRepository;
    }

    /**
     * Sets Klarna authorization_token and saves information in database
     *
     * @param SetPaymentMethodOnCart $setPaymentMethodOnCart
     * @param $resolve
     * @param Quote $cart
     * @param array $paymentData
     * @return void
     */
    public function afterExecute(
        SetPaymentMethodOnCart $setPaymentMethodOnCart,
        $resolve,
        Quote $cart,
        array $paymentData
    ): void {
        $paymentCode = $paymentData['code'];
        if ($paymentCode !== ConfigHelper::KP_METHOD_CODE) {
            return;
        }

        $authorizationToken = $paymentData[$paymentCode]['authorization_token'];

        try {
            /** @var QuoteInterface $klarnaQuote */
            $klarnaQuote = $this->klarnaQuoteRepository->getActiveByQuote($cart);
            $klarnaQuote->setAuthorizationToken($authorizationToken);

            $payment = $cart->getPayment();
            $payment->setAdditionalInformation('method_title', self::KLARNA_TITLE);
            $payment->setAdditionalInformation('method_code', $payment->getMethodInstance()->getCode());
            $payment->setAdditionalInformation('klarna_order_id', $klarnaQuote->getSessionId());

            $this->klarnaQuoteRepository->save($klarnaQuote);
        } catch (NoSuchEntityException $e) {
            $data = ['klarna_id' => $authorizationToken];
            $this->logger->error($e, $data);
            throw new GraphQlInputException(__('Sorry, but something went wrong'));
        }
    }
}
