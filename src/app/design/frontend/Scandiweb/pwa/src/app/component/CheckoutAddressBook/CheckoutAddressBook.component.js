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
import { customerType, ADDRESS_BOOK } from 'Type/Account';
import { MY_ACCOUNT_URL } from 'Route/MyAccount/MyAccount.container';
import Link from 'Component/Link';
import CheckoutAddressTable from 'Component/CheckoutAddressTable';
import Loader from 'Component/Loader';
import CheckoutAddressForm from 'Component/CheckoutAddressForm';
import './CheckoutAddressBook.style';
import { BILLING_STEP, SHIPPING_STEP } from 'Route/Checkout/Checkout.component';

class CheckoutAddressBook extends PureComponent {
    static propTypes = {
        customer: customerType.isRequired,
        onAddressSelect: PropTypes.func.isRequired,
        onShippingEstimationFieldsChange: PropTypes.func.isRequired,
        selectedAddressId: PropTypes.number.isRequired,
        isSignedIn: PropTypes.bool.isRequired,
        isBilling: PropTypes.bool.isRequired
    };

    state = {
        isCustomAddressExpanded: false
    };

    static getDerivedStateFromProps(props) {
        const { selectedAddressId } = props;
        if (selectedAddressId === 0) return null;
        return { isCustomAddressExpanded: false };
    }

    expandCustomAddress = () => {
        const { onAddressSelect } = this.props;
        this.setState({ isCustomAddressExpanded: true });
        onAddressSelect({});
    };

    renderNoAddresses() {
        return (
            <div>
                <p>{ __('You have no configured addresses.') }</p>
                <p>
                    <Link to={ `${ MY_ACCOUNT_URL }/${ ADDRESS_BOOK }` }>
                        { __('Go to Address Book to configure them!') }
                    </Link>
                </p>
            </div>
        );
    }

    renderLoading() {
        return (
            <Loader isLoading />
        );
    }

    renderAddress = (address) => {
        const { onAddressSelect, selectedAddressId } = this.props;
        const { id } = address;

        return (
            <CheckoutAddressTable
              onClick={ onAddressSelect }
              isSelected={ selectedAddressId === id }
              title={ __('Address #%s', id) }
              address={ address }
              key={ id }
            />
        );
    };

    renderAddressList() {
        const { customer: { addresses } } = this.props;
        if (!addresses) return this.renderLoading();
        if (!addresses.length) return this.renderNoAddresses();
        return addresses.map(this.renderAddress);
    }

    renderHeading() {
        const { isBilling } = this.props;
        const addressName = isBilling ? __('Select billing address') : __('Select shipping address');

        return (
            <h2 block="Checkout" elem="Heading">
                { addressName }
            </h2>
        );
    }

    renderCustomAddress() {
        const { isBilling, onShippingEstimationFieldsChange } = this.props;
        const formPortalId = isBilling ? BILLING_STEP : SHIPPING_STEP;

        return (
            <CheckoutAddressForm
              onShippingEstimationFieldsChange={ onShippingEstimationFieldsChange }
              address={ {} }
              id={ formPortalId }
            />
        );
    }

    renderOptionalCustomAddress() {
        const { isCustomAddressExpanded } = this.state;

        return (
            <div
              block="CheckoutAddressBook"
              elem="CustomAddressWrapper"
            >
                <button
                  block="CheckoutAddressBook"
                  elem="Button"
                  mods={ { isCustomAddressExpanded } }
                  mix={ { block: 'Button', mods: { isHollow: true } } }
                  type="button"
                  onClick={ this.expandCustomAddress }
                >
                    { __('Use custom address') }
                </button>
                { isCustomAddressExpanded && this.renderCustomAddress() }
            </div>
        );
    }

    renderSignedInContent() {
        return (
            <>
                <div block="CheckoutAddressBook" elem="Wrapper">
                    { this.renderAddressList() }
                </div>
                { this.renderOptionalCustomAddress() }
            </>
        );
    }

    renderGuestContent() {
        return this.renderCustomAddress();
    }

    renderContent() {
        const { isSignedIn } = this.props;
        if (isSignedIn) return this.renderSignedInContent();
        return this.renderGuestContent();
    }

    render() {
        return (
            <div block="CheckoutAddressBook">
                { this.renderHeading() }
                { this.renderContent() }
            </div>
        );
    }
}

export default CheckoutAddressBook;
