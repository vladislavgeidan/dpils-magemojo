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

import PropTypes from 'prop-types';
import { PureComponent } from 'react';

import MyAccountOrderTableRow from 'Component/MyAccountOrderTableRow';
import MyAccountOrderPopup from 'Component/MyAccountOrderPopup';
import { ordersType } from 'Type/Account';
import Loader from 'Component/Loader';
import isMobile from 'Util/Mobile';

import './MyAccountMyOrders.style';

class MyAccountMyOrders extends PureComponent {
    static propTypes = {
        orderList: ordersType.isRequired,
        isLoading: PropTypes.bool.isRequired
    };

    renderPopup() {
        return <MyAccountOrderPopup />;
    }

    renderNoOrders() {
        return (
            <tr block="MyAccountMyOrders" elem="NoOrders">
                { /* eslint-disable-next-line no-magic-numbers */ }
                <td colSpan={ isMobile.any() ? 3 : 4 }>{ __('You have no orders.') }</td>
            </tr>
        );
    }

    renderTable() {
        return (
            <table block="MyAccountMyOrders" elem="Table">
                <thead>
                    <tr>
                        <th>{ __('Order') }</th>
                        <th>{ __('Date') }</th>
                        <th>{ __('Status') }</th>
                        <th block="hidden-mobile">{ __('Total') }</th>
                    </tr>
                </thead>
                <tbody>
                    { this.renderOrdersList() }
                </tbody>
            </table>
        );
    }

    renderOrderRow = (order) => {
        const { base_order_info: { id } } = order;

        return (
            <MyAccountOrderTableRow
              key={ id }
              order={ order }
            />
        );
    };

    renderOrdersList() {
        const { orderList, isLoading } = this.props;

        if (!isLoading && !orderList.length) return this.renderNoOrders();

        const orders = orderList.length
            ? orderList
            : Array.from({ length: 10 }, (_, id) => ({ base_order_info: { id } }));

        return orders.reduceRight(
            (acc, e) => [...acc, this.renderOrderRow(e)],
            []
        );
    }

    render() {
        const { isLoading } = this.props;

        return (
            <>
                <div block="MyAccountMyOrders">
                    <Loader isLoading={ isLoading } />
                    { this.renderTable() }
                    { this.renderPopup() }
                </div>
            </>
        );
    }
}

export default MyAccountMyOrders;
