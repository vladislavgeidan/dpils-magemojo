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

import Popup from 'Component/Popup';
import { orderType } from 'Type/Account';
import Loader from 'Component/Loader';
import MyAccountAddressTable from 'Component/MyAccountAddressTable';
import Image from 'Component/Image';
import { formatCurrency } from 'Util/Price';

import './MyAccountOrderPopup.style';

export const ORDER_POPUP_ID = 'MyAccountOrderPopup';

class MyAccountOrderPopup extends PureComponent {
    static propTypes = {
        order: orderType.isRequired,
        isLoading: PropTypes.bool.isRequired,
        currency_code: PropTypes.string.isRequired
    };

    renderBaseInfo() {
        const { order: { base_order_info } } = this.props;
        const { status_label, created_at } = base_order_info || {};

        return (
            <div>
                <h4>{ __('Order details') }</h4>
                <dl>
                    <dt>{ __('Created at: ') }</dt>
                    <dd>{ created_at }</dd>
                    <dt>{ __('Status: ') }</dt>
                    <dd>{ status_label }</dd>
                </dl>
            </div>
        );
    }

    renderPayment() {
        const { order: { payment_info } } = this.props;
        const { additional_information: { method_title } = {} } = payment_info || {};

        return (
            <div>
                <h4>{ __('Payment Information') }</h4>
                <dl>
                    <dt>{ __('Method: ') }</dt>
                    <dd>{ method_title }</dd>
                </dl>
            </div>
        );
    }

    renderShippingAddressTable() {
        const { order: { shipping_info: { shipping_address } } } = this.props;

        return (
            <MyAccountAddressTable
              title={ __('Shipping address') }
              address={ shipping_address }
              mix={ { block: 'MyAccountOrderPopup', elem: 'Address' } }
            />
        );
    }

    renderShipping() {
        const { order: { shipping_info }, currency_code } = this.props;

        const {
            shipping_description,
            shipping_amount,
            shipping_address
        } = shipping_info || {};

        if (!shipping_address) return null;

        return (
            <div block="MyAccountOrderPopup" elem="ShippingWrapper">
                <h4>{ __('Shipping & Handling Information') }</h4>
                <dl>
                    <dt>{ __('Description: ') }</dt>
                    <dd>
                        { shipping_description }
                    </dd>
                    <dt>{ __('Price: ') }</dt>
                    <dd>
                        { formatCurrency(currency_code) }
                        { shipping_amount }
                    </dd>
                </dl>
                { this.renderShippingAddressTable() }
            </div>
        );
    }

    renderItems() {
        const { order: { order_products = [] }, currency_code } = this.props;

        return order_products.map((product, i) => {
            const {
                name,
                thumbnail,
                id,
                qty,
                row_total
            } = product;

            const { url } = thumbnail || {};

            return (
                <tr
                  key={ id || i.toString() }
                  block="MyAccountOrderPopup"
                  elem="Row"
                >
                    <td>
                        { url && (
                            <Image
                              src={ url }
                              alt={ name }
                              mix={ { block: 'MyAccountOrderPopup', elem: 'Thumbnail' } }
                            />
                        ) }
                    </td>
                    <td>{ name }</td>
                    <td>{ qty }</td>
                    <td>
                        { formatCurrency(currency_code) }
                        { row_total }
                    </td>
                </tr>
            );
        });
    }

    renderProducts() {
        return (
            <div block="MyAccountOrderPopup" elem="ProductsWrapper">
                <h4>{ __('Items Ordered') }</h4>
                <table
                  block="MyAccountOrderPopup"
                  elem="Products"
                >
                    <thead>
                        <tr>
                            <th>{ __('Image') }</th>
                            <th>{ __('Name') }</th>
                            <th>{ __('Quantity') }</th>
                            <th>{ __('Total') }</th>
                        </tr>
                    </thead>
                    <tbody>
                        { this.renderItems() }
                    </tbody>
                </table>
            </div>
        );
    }

    renderTotals() {
        const { order: { base_order_info }, currency_code } = this.props;
        const { grand_total, sub_total } = base_order_info || {};

        return (
            <div block="MyAccountOrderPopup" elem="OrderWrapper">
                <h4>{ __('Order Total') }</h4>
                <dl>
                    <dt>{ __('Subtotal: ') }</dt>
                    <dd>
                        { formatCurrency(currency_code) }
                        { sub_total }
                    </dd>
                    <dt>{ __('Grand total: ') }</dt>
                    <dd>
                        { formatCurrency(currency_code) }
                        { grand_total }
                    </dd>
                </dl>
            </div>
        );
    }

    renderContent() {
        const { order: { order_products } } = this.props;

        if (!order_products) return null;

        return (
            <>
                { this.renderBaseInfo() }
                { this.renderPayment() }
                { this.renderShipping() }
                { this.renderProducts() }
                { this.renderTotals() }
            </>
        );
    }

    render() {
        const { isLoading } = this.props;

        return (
            <Popup
              id={ ORDER_POPUP_ID }
              mix={ { block: 'MyAccountOrderPopup' } }
            >
                <div block="MyAccountOrderPopup" elem="Content">
                    <Loader isLoading={ isLoading } />
                    { this.renderContent() }
                </div>
            </Popup>
        );
    }
}

export default MyAccountOrderPopup;
