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
import { customerType } from 'Type/Account';
import MyAccountCustomerForm from 'Component/MyAccountCustomerForm';
import MyAccountPasswordForm from 'Component/MyAccountPasswordForm';
import Loader from 'Component/Loader';

export const CUSTOMER_POPUP_ID = 'MyAccountCustomerPopup';

export const CHANGE_PASSWORD = 'CHANGE_PASSWORD';
export const EDIT_CUSTOMER = 'EDIT_CUSTOMER';

class MyAccountCustomerPopup extends PureComponent {
    static propTypes = {
        onCustomerSave: PropTypes.func.isRequired,
        onPasswordChange: PropTypes.func.isRequired,
        isLoading: PropTypes.bool.isRequired,
        payload: PropTypes.shape({
            action: PropTypes.oneOf([
                CHANGE_PASSWORD,
                EDIT_CUSTOMER
            ]),
            customer: customerType
        }).isRequired
    };

    renderChangePasswordForm() {
        const { onPasswordChange } = this.props;

        return (
            <MyAccountPasswordForm
              onPasswordChange={ onPasswordChange }
            />
        );
    }

    renderCustomerForm() {
        const { payload: { customer }, onCustomerSave } = this.props;

        return (
            <MyAccountCustomerForm
              customer={ customer }
              onSave={ onCustomerSave }
            />
        );
    }

    renderContent() {
        const { payload: { action } } = this.props;

        switch (action) {
        case CHANGE_PASSWORD:
            return this.renderChangePasswordForm();
        case EDIT_CUSTOMER:
            return this.renderCustomerForm();
        default:
            return null;
        }
    }

    render() {
        const { isLoading } = this.props;

        return (
            <Popup
              id={ CUSTOMER_POPUP_ID }
              clickOutside={ false }
              mix={ { block: 'MyAccountCustomerPopup' } }
            >
                <Loader isLoading={ isLoading } />
                { this.renderContent() }
            </Popup>
        );
    }
}

export default MyAccountCustomerPopup;
