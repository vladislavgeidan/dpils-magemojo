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
import { withRouter } from 'react-router-dom';

import { generateQuery, getQueryParam } from 'Util/Url';
import { HistoryType } from 'Type/Common';
import { LocationType } from 'Type/Router';

import CategoryPagination from './CategoryPagination.component';

export class CategoryPaginationContainer extends PureComponent {
    static propTypes = {
        isLoading: PropTypes.bool,
        onPageSelect: PropTypes.func,
        history: HistoryType.isRequired,
        location: LocationType.isRequired,
        totalPages: PropTypes.number.isRequired
    };

    static defaultProps = {
        isLoading: false,
        onPageSelect: () => {}
    };

    containerFunctions = () => ({
        getSearchQuery: this.getSearchQuery
    });

    getSearchQuery = (pageNumber) => {
        const { history, location } = this.props;
        const page = pageNumber !== 1 ? pageNumber : '';
        return generateQuery({ page }, location, history);
    };

    containerProps = () => ({
        currentPage: this._getCurrentPage()
    });

    _getCurrentPage() {
        const { location } = this.props;

        return +(getQueryParam('page', location) || 1);
    }

    render() {
        const { location: { pathname } } = this.props;

        return (
            <CategoryPagination
              pathname={ pathname }
              { ...this.props }
              { ...this.containerFunctions() }
              { ...this.containerProps() }
            />
        );
    }
}

export default withRouter(CategoryPaginationContainer);
