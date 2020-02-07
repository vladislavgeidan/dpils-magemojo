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
import { connect } from 'react-redux';

import { MyAccountQuery } from 'Query';
import { hideActiveOverlay } from 'Store/Overlay';
import { fetchMutation } from 'Util/Request';
import { addressType } from 'Type/Account';
import { showNotification } from 'Store/Notification';
import { MyAccountDispatcher } from 'Store/MyAccount';
import { goToPreviousNavigationState } from 'Store/Navigation';
import { TOP_NAVIGATION_TYPE } from 'Store/Navigation/Navigation.reducer';

import MyAccountAddressPopup, { ADDRESS_POPUP_ID } from './MyAccountAddressPopup.component';

export const mapStateToProps = state => ({
    payload: state.PopupReducer.popupPayload[ADDRESS_POPUP_ID] || {}
});

export const mapDispatchToProps = dispatch => ({
    hideActiveOverlay: () => dispatch(hideActiveOverlay()),
    showErrorNotification: error => dispatch(showNotification('error', error[0].message)),
    showSuccessNotification: message => dispatch(showNotification('success', message)),
    updateCustomerDetails: () => MyAccountDispatcher.requestCustomerData(dispatch),
    goToPreviousHeaderState: () => dispatch(goToPreviousNavigationState(TOP_NAVIGATION_TYPE))
});

export class MyAccountAddressPopupContainer extends PureComponent {
    static propTypes = {
        showErrorNotification: PropTypes.func.isRequired,
        updateCustomerDetails: PropTypes.func.isRequired,
        hideActiveOverlay: PropTypes.func.isRequired,
        goToPreviousHeaderState: PropTypes.func.isRequired,
        payload: PropTypes.shape({
            address: addressType
        }).isRequired
    };

    state = {
        isLoading: false
    };

    containerFunctions = {
        handleAddress: this.handleAddress.bind(this),
        handleDeleteAddress: this.handleDeleteAddress.bind(this)
    };

    handleAfterAction = () => {
        const {
            hideActiveOverlay,
            updateCustomerDetails,
            showErrorNotification,
            goToPreviousHeaderState
        } = this.props;

        updateCustomerDetails().then(() => {
            this.setState({ isLoading: false }, () => {
                hideActiveOverlay();
                goToPreviousHeaderState();
            });
        }, showErrorNotification);
    };

    handleError = (error) => {
        const { showErrorNotification } = this.props;
        showErrorNotification(error);
        this.setState({ isLoading: false });
    };

    handleAddress(address) {
        const { payload: { address: { id } } } = this.props;
        this.setState({ isLoading: true });
        if (id) return this.handleEditAddress(address);
        return this.handleCreateAddress(address);
    }

    handleEditAddress(address) {
        const { payload: { address: { id } } } = this.props;
        const query = MyAccountQuery.getUpdateAddressMutation(id, address);
        fetchMutation(query).then(this.handleAfterAction, this.handleError);
    }

    handleDeleteAddress() {
        const { payload: { address: { id } } } = this.props;
        this.setState({ isLoading: true });
        const query = MyAccountQuery.getDeleteAddressMutation(id);
        fetchMutation(query).then(this.handleAfterAction, this.handleError);
    }

    handleCreateAddress(address) {
        const query = MyAccountQuery.getCreateAddressMutation(address);
        fetchMutation(query).then(this.handleAfterAction, this.handleError);
    }

    render() {
        return (
            <MyAccountAddressPopup
              { ...this.props }
              { ...this.state }
              { ...this.containerFunctions }
            />
        );
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(MyAccountAddressPopupContainer);
