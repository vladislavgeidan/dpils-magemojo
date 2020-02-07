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

import { Field } from 'Util/Query';
import { isSignedIn } from 'Util/Auth';

export class CheckoutQuery {
    getPaymentMethodsQuery(guestCartId) {
        const query = new Field('getPaymentMethods')
            .addFieldList(this._getPaymentMethodFields());

        this._addGuestCartId(guestCartId, query);

        return query;
    }

    getSaveGuestEmailMutation(email, cart_id) {
        const input = { email, cart_id };
        const mutation = new Field('setGuestEmailOnCart')
            .addArgument('input', 'SetGuestEmailOnCartInput', input)
            .addField(((new Field('cart')).addField('email')));

        return mutation;
    }

    getEstimateShippingCosts(address, guestCartId) {
        const mutation = new Field('estimateShippingCosts')
            .addArgument('address', 'EstimateShippingCostsAddress!', address)
            .addFieldList(this._getEstimatedShippingFields());

        this._addGuestCartId(guestCartId, mutation);

        return mutation;
    }

    getSaveAddressInformation(addressInformation, guestCartId) {
        const mutation = new Field('saveAddressInformation')
            .addArgument('addressInformation', 'SaveAddressInformation!', addressInformation)
            .addFieldList(this._getSaveAddressInformationFields());

        this._addGuestCartId(guestCartId, mutation);

        return mutation;
    }

    getSavePaymentInformationAndPlaceOrder(paymentInformation, guestCartId) {
        const mutation = new Field('savePaymentInformationAndPlaceOrder')
            .addArgument('paymentInformation', 'PaymentInformation!', paymentInformation)
            .addFieldList(this._getSavePaymentInformationAndPlaceOrderFields());

        this._addGuestCartId(guestCartId, mutation);

        return mutation;
    }

    getSetPaymentMethodOnCartMutation(input) {
        return new Field('s_setPaymentMethodOnCart')
            .addArgument('input', 'S_SetPaymentMethodOnCartInput!', input)
            .addField(this._getCartField())
            .setAlias('paymentMethod');
    }

    getPlaceOrderMutation(guestCartId) {
        const mutation = new Field('s_placeOrder')
            .setAlias('placeOrder')
            .addField(this._getOrderField());

        if (!isSignedIn()) mutation.addArgument('guestCartId', 'String', guestCartId);

        return mutation;
    }

    _addGuestCartId(guestCartId, mutation) {
        if (guestCartId && !isSignedIn()) mutation.addArgument('guestCartId', 'String!', guestCartId);
    }

    _getOrderField() {
        return new Field('order')
            .addFieldList(['order_id']);
    }

    _getSavePaymentInformationAndPlaceOrderFields() {
        return [
            'orderID'
        ];
    }

    _getSaveAddressInformationFields() {
        return [
            this._getPaymentMethodsField(),
            this._getTotalsField()
        ];
    }


    _getEstimatedShippingFields() {
        return [
            'amount',
            'available',
            'base_amount',
            'method_code',
            'carrier_code',
            'method_title',
            'carrier_title',
            'error_message',
            'price_excl_tax',
            'price_incl_tax'
        ];
    }

    _getPaymentMethodsField() {
        return new Field('payment_methods')
            .addFieldList(this._getPaymentMethodFields());
    }

    _getPaymentMethodFields() {
        return ['code', 'title'];
    }

    _getTotalItemFields() {
        return [
            'qty',
            'name',
            'price',
            'item_id',
            'options',
            'tax_amount',
            'tax_percent',
            'price_incl_tax',
            'discount_amount',
            'discount_percent'
        ];
    }

    _getTotalItemField() {
        return new Field('items')
            .addFieldList(this._getTotalItemFields());
    }

    _getTotalsFields() {
        return [
            'subtotal',
            'tax_amount',
            'base_grand_total',
            'grand_total',
            'discount_amount',
            'shipping_amount',
            'subtotal_incl_tax',
            'shipping_incl_tax',
            'quote_currency_code',
            'shipping_tax_amount',
            'subtotal_with_discount',
            'shipping_discount_amount',
            this._getTotalItemField()
        ];
    }

    _getTotalsField() {
        return new Field('totals')
            .addFieldList(this._getTotalsFields());
    }

    _getCartField() {
        return new Field('cart')
            .addFieldList(this._getCartFieldList());
    }

    _getCartFieldList() {
        return [
            this._getSelectedPaymentMethodField()
        ];
    }

    _getSelectedPaymentMethodField() {
        return new Field('selected_payment_method')
            .addFieldList([
                'code',
                'title',
                'purchase_order_number'
            ]);
    }

    _getAvailablePaymentMethodsField() {
        return new Field('available_payment_methods')
            .addFieldList([
                'code',
                'title'
            ]);
    }

    _getAppliedCouponField() {
        return new Field('applied_coupon')
            .addField('code');
    }
}

export default new CheckoutQuery();
