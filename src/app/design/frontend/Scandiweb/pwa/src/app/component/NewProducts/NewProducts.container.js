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
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { prepareQuery } from 'Util/Query';
import { ProductListQuery } from 'Query';
import { executeGet } from 'Util/Request';
import { showNotification } from 'Store/Notification';
import { getIndexedProducts } from 'Util/Product';
import NewProducts from './NewProducts.component';

const mapStateToProps = state => ({
    timezone: state.ConfigReducer.timezone
});

const mapDispatchToProps = dispatch => ({
    showNotification: (type, title, error) => dispatch(showNotification(type, title, error))
});

export class NewProductsContainer extends PureComponent {
    static propTypes = {
        category: PropTypes.string,
        cacheLifetime: PropTypes.number,
        productsCount: PropTypes.number,
        timezone: PropTypes.string.isRequired,
        showNotification: PropTypes.func.isRequired
    };

    static defaultProps = {
        category: '',
        productsCount: 10,
        cacheLifetime: 86400
    };

    state = {
        products: undefined
    };

    componentDidMount() {
        this.requestProducts();
    }

    componentDidUpdate(prevProps) {
        const {
            category,
            productsCount,
            cacheLifetime,
            timezone
        } = this.props;
        const {
            category: pCategory,
            productsCount: pProductsCount,
            cacheLifetime: pCacheLifetime,
            timezone: pTimezone
        } = prevProps;

        if (category !== pCategory
            || timezone !== pTimezone
            || productsCount !== pProductsCount
            || cacheLifetime !== pCacheLifetime) {
            this.requestProducts();
        }
    }

    /**
     * Calculates date for request in server locale and with ttl error
     *
     * @returns {Date}
     * @memberof NewProducts
     */
    getRequestDate() {
        const { cacheLifetime, timezone: timeZone } = this.props;
        const milliInSeccond = 1000;

        const now = new Date();
        const serverNow = new Date(now.toLocaleString('en', { timeZone }));

        const serverNowTime = serverNow.getTime();
        const ttl = cacheLifetime * milliInSeccond;

        const requestTime = serverNowTime - (serverNowTime % ttl);
        const requestDate = new Date(requestTime);

        const timeOffset = 10;
        return requestDate.toISOString().slice(0, timeOffset);
    }

    requestProducts() {
        const {
            timezone,
            category: categoryUrlPath,
            productsCount: pageSize,
            cacheLifetime,
            showNotification
        } = this.props;

        if (!timezone) return;

        const newToDate = this.getRequestDate();

        const options = {
            args: {
                filter: {
                    categoryUrlPath,
                    newToDate
                },
                currentPage: 1,
                pageSize
            }
        };

        const query = [ProductListQuery.getQuery(options)];
        executeGet(prepareQuery(query), 'NewProducts', cacheLifetime)
            .then(({ products: { items } }) => this.setState({ products: getIndexedProducts(items) }))
            .catch(e => showNotification('error', 'Error fetching NewProducts!', e));
    }

    render = () => <NewProducts { ...this.props } { ...this.state } />;
}

export default connect(mapStateToProps, mapDispatchToProps)(NewProductsContainer);
