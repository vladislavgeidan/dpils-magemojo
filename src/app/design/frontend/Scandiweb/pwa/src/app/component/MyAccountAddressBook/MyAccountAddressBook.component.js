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
import { customerType } from 'Type/Account';
import MyAccountAddressTable from 'Component/MyAccountAddressTable';
import MyAccountAddressPopup from 'Component/MyAccountAddressPopup';
import './MyAccountAddressBook.style';

class MyAccountAddressBook extends PureComponent {
    static propTypes = {
        customer: customerType.isRequired,
        getDefaultPostfix: PropTypes.func.isRequired,
        showCreateNewPopup: PropTypes.func.isRequired
    };

    renderPopup() {
        return <MyAccountAddressPopup />;
    }

    renderAddress = (address) => {
        const { getDefaultPostfix } = this.props;
        const { id } = address;
        const postfix = getDefaultPostfix(address);

        return (
            <MyAccountAddressTable
              title={ __('Address #%s%s', id, postfix) }
              showActions
              address={ address }
              key={ id }
            />
        );
    };

    renderNoAddresses() {
        return (
            <div>
                <p>{ __('You have no configured addresses.') }</p>
            </div>
        );
    }

    renderActions() {
        const { showCreateNewPopup } = this.props;

        return (
            <button
              block="MyAccountAddressBook"
              elem="Button"
              mix={ { block: 'Button' } }
              onClick={ showCreateNewPopup }
            >
                { __('Add new address') }
            </button>
        );
    }

    renderAddressList() {
        const { customer: { addresses = [] } } = this.props;
        if (!addresses.length) return this.renderNoAddresses();
        return addresses.map(this.renderAddress);
    }

    render() {
        return (
            <div block="MyAccountAddressBook">
                { this.renderActions() }
                { this.renderAddressList() }
                { this.renderPopup() }
            </div>
        );
    }
}

export default MyAccountAddressBook;
