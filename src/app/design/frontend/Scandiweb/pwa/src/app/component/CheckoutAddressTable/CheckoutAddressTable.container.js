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

import { connect } from 'react-redux';

import {
    MyAccountAddressTableContainer,
    mapDispatchToProps,
    mapStateToProps
} from 'Component/MyAccountAddressTable/MyAccountAddressTable.container';

import CheckoutAddressTable from './CheckoutAddressTable.component';

export class CheckoutAddressTableContainer extends MyAccountAddressTableContainer {
    render() {
        return (
            <CheckoutAddressTable
              { ...this.props }
              { ...this.containerFunctions }
            />
        );
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(CheckoutAddressTableContainer);
