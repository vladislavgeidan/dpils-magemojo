/**
 * ScandiPWA - Progressive Web App for Magento
 *
 * Copyright © Scandiweb, Inc. All rights reserved.
 * See LICENSE for license details.
 *
 * @license OSL-3.0 (Open Software License ("OSL") v. 3.0)
 * @package scandipwa/base-theme
 * @link https://github.com/scandipwa/base-theme
 */

import { PureComponent } from 'react';
import PropTypes from 'prop-types';

import { shippingMethodType } from 'Type/Checkout';
import { TotalsType } from 'Type/MiniCart';

import './CheckoutDeliveryOption.style';
import { formatCurrency, roundPrice } from 'Util/Price';

class CheckoutDeliveryOption extends PureComponent {
    static propTypes = {
        option: shippingMethodType.isRequired,
        onClick: PropTypes.func.isRequired,
        isSelected: PropTypes.bool,
        totals: TotalsType.isRequired
    };

    static defaultProps = {
        isSelected: false
    };

    onClick = () => {
        const {
            onClick,
            option
        } = this.props;

        onClick(option);
    };

    renderPrice() {
        const {
            option: { price_incl_tax },
            totals: { quote_currency_code }
        } = this.props;

        const roundedUpPrice = roundPrice(price_incl_tax);

        return (
            <strong>
                { ` - ${roundedUpPrice}${formatCurrency(quote_currency_code)}` }
            </strong>
        );
    }

    render() {
        const {
            isSelected,
            option: { carrier_title, method_title }
        } = this.props;

        return (
            <li block="CheckoutDeliveryOption">
                <button
                  block="CheckoutDeliveryOption"
                  mods={ { isSelected } }
                  elem="Button"
                  onClick={ this.onClick }
                  type="button"
                >
                    <div block="CheckoutDeliveryOption" elem="Row">
                        <span>
                            { __('Carrier method: ') }
                            <strong>{ carrier_title }</strong>
                        </span>
                        <br />
                        <span>
                            { __('Rate: ') }
                            <strong>{ method_title }</strong>
                        </span>
                        { this.renderPrice() }
                    </div>
                </button>
            </li>
        );
    }
}

export default CheckoutDeliveryOption;
