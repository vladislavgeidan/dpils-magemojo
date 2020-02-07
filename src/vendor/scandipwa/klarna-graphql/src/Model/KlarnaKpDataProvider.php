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

namespace ScandiPWA\KlarnaGraphQl\Model;

use Klarna\Core\Helper\ConfigHelper;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\QuoteGraphQl\Model\Cart\Payment\AdditionalDataProviderInterface;

/**
 * Format Klarna input into value expected when setting payment method
 */
class KlarnaKpDataProvider implements AdditionalDataProviderInterface
{
    /**
     * Format Klarna input into value expected when setting payment method
     *
     * @param array $args
     * @return array
     * @throws GraphQlInputException
     */
    public function getData(array $args): array
    {
        if (!isset($args[ConfigHelper::KP_METHOD_CODE])) {
            throw new GraphQlInputException(
                __('Required parameter "klarna_kp" for "payment_method" is missing.')
            );
        }

        if (!isset($args[ConfigHelper::KP_METHOD_CODE]['authorization_token'])) {
            throw new GraphQlInputException(
                __('Required parameter "authorization_token" for "braintree" is missing.')
            );
        }

        return $args[ConfigHelper::KP_METHOD_CODE];
    }
}
