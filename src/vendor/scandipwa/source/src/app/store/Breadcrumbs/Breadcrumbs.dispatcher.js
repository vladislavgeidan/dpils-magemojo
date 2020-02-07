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

import { updateBreadcrumbs, toggleBreadcrumbs } from 'Store/Breadcrumbs';

/**
 * Breadcrumbs Dispatcher
 * @class BreadcrumbsDispatcher
 */
export class BreadcrumbsDispatcher {
    /**
     * Set breadcrumbs
     * @param {Array<Object>} breadcrumbs Breadcrumbs array
     * @param {Function} dispatch
     * @memberof BreadcrumbsDispatcher
     */
    update(breadcrumbs, dispatch) {
        dispatch(toggleBreadcrumbs(true));
        dispatch(updateBreadcrumbs(breadcrumbs));
    }

    /**
     * Set breadcrumbs for category
     * @param {Array<Object>} category Category breadcumbs items
     * @param {Function} dispatch
     * @memberof BreadcrumbsDispatcher
     */
    updateWithCategory(category, dispatch) {
        const breadcrumbs = this._getCategoryBreadcrumbs(category);
        dispatch(toggleBreadcrumbs(true));
        dispatch(updateBreadcrumbs(breadcrumbs));
    }

    /**
     * Set breadcrumbs for category
     * @param {Array<Object>} category Category breadcumbs items
     * @param {Function} dispatch
     * @memberof BreadcrumbsDispatcher
     */
    updateWithProduct(product, dispatch) {
        const breadcrumbs = this._getProductBreadcrumbs(product);
        dispatch(toggleBreadcrumbs(true));
        dispatch(updateBreadcrumbs(breadcrumbs));
    }

    /**
     * Set breadcrumbs for category
     * @param {Array<Object>} category Category breadcumbs items
     * @param {Function} dispatch
     * @memberof BreadcrumbsDispatcher
     */
    updateWithCmsPage({ title }, dispatch) {
        const breadcrumbs = title
            ? [
                {
                    url: '',
                    name: title
                },
                {
                    url: '/',
                    name: 'Home'
                }
            ]
            : [];

        dispatch(updateBreadcrumbs(breadcrumbs));
    }

    /**
     * Get breadcrumbs for category
     * @param {Object} category Category breadcumbs items
     * @return {Array<Object>} Breadcrumbs array
     * @memberof BreadcrumbsDispatcher
     */
    _getCategoryBreadcrumbs(category) {
        const { url_path, name, breadcrumbs } = category;
        const breadcrumbsList = [];

        if (breadcrumbs) {
            breadcrumbs.sort((a, b) => b.category_level - a.category_level)
                .map(({ category_name, category_url_key }) => breadcrumbsList.push({
                    url: `/category/${category_url_key}`,
                    name: category_name
                }));
        }

        return [
            { url: `/category/${url_path}`, name },
            ...breadcrumbsList
        ];
    }

    /**
     * Get breadcrumbs for product
     * @param {Object} product Product breadcumbs items
     * @return {Array<Object>} Breadcrumbs array
     * @memberof BreadcrumbsDispatcher
     */
    _getProductBreadcrumbs(product) {
        const { categories, url_key, name } = product;
        const breadcrumbsList = [];

        if (categories && categories.length) {
            const { breadcrumbsCategory = {} } = categories.reduce((acc, category) => {
                const { longestBreadcrumbsLength } = acc;
                const { breadcrumbs } = category;
                const breadcrumbsLength = (breadcrumbs || []).length;

                if (!breadcrumbsLength && longestBreadcrumbsLength !== 0) return acc;

                if (longestBreadcrumbsLength === 0) return { ...acc, breadcrumbsCategory: category };

                if (breadcrumbsLength <= longestBreadcrumbsLength) return acc;

                return {
                    breadcrumbsCategory: category,
                    longestBreadcrumbsLength: breadcrumbsLength
                };
            }, { breadcrumbsCategory: {}, longestBreadcrumbsLength: 0 });

            breadcrumbsList.push(...this._getCategoryBreadcrumbs(breadcrumbsCategory));
        }

        return [
            { url: `/product/${url_key}`, name },
            ...breadcrumbsList
        ];
    }
}

export default new BreadcrumbsDispatcher();
