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

import { QueryDispatcher } from 'Util/Request';
import { ProductListQuery } from 'Query';
import { updateSearchBar, updateLoadStatus, clearSearchResults } from './SearchBar.action';

/**
 * Search Bar Dispatcher
 * @class SearchBarDispatcher
 * @extends QueryDispatcher
 */
export class SearchBarDispatcher extends QueryDispatcher {
    constructor() {
        super('SearchBar');
    }

    onSuccess(data, dispatch) {
        dispatch(updateLoadStatus(false));
        dispatch(updateSearchBar(data));
    }

    onError(_, dispatch) {
        dispatch(updateLoadStatus(false));
    }

    clearSearchResults(dispatch) {
        dispatch(clearSearchResults());
    }

    prepareRequest(options, dispatch) {
        dispatch(updateLoadStatus(true));
        return ProductListQuery.getQuery({
            ...options,
            notRequireInfo: true
        });
    }
}

export default new SearchBarDispatcher();
