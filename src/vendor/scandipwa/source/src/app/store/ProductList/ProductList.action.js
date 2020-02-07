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

export const APPEND_PAGE = 'APPEND_PAGE';
export const UPDATE_PRODUCT_LIST_ITEMS = 'UPDATE_PRODUCT_LIST_ITEMS';
export const UPDATE_LOAD_STATUS = 'UPDATE_LOAD_STATUS';

/**
 * Append page to the list.
 * @param {Array<Object>} items List of products returned from fetch
 * @param {Number} minPrice Minimal products price returned from fetch
 * @param {Number} maxPrice Maximal products price returned from fetch
 * @param {Number} currentPage Number of requested page
 */
export const appendPage = (items, currentPage) => ({
    type: APPEND_PAGE,
    items,
    currentPage
});

/**
 * Update product list with new list (rewrite if already exists).
 * @param {Array<Object>} items List of products returned from fetch
 * @param {Number} currentPage Number of requested page
 * @param {Number} total_count Number of requested page
 * @return {void}
 */
export const updateProductListItems = (items, currentPage, total_count, total_pages) => ({
    type: UPDATE_PRODUCT_LIST_ITEMS,
    items,
    currentPage,
    total_pages,
    total_count
});

/**
 * Update loading status
 * @param {Boolean} status Loading indication boolean
 * @return {void}
 */
export const updateLoadStatus = status => ({
    type: UPDATE_LOAD_STATUS,
    isLoading: status
});
