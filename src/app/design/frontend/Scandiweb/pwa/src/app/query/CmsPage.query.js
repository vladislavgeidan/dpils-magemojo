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

import { Field } from 'Util/Query';

/**
 * CMS Page Query
 * @class CmsPageQuery
 */
export class CmsPageQuery {
    /**
     * get CMS Page query
     * @param  {{url_key: String, title: Int, content: String, content_heading: String, page_layout: String, meta_title: String, meta_description: String, meta_keywords, string}} options A object containing different aspects of query, each item can be omitted
     * @return {Query} CMS Page query
     * @memberof CmsPageQuery
     */
    getQuery({ id }) {
        if (!id) throw new Error('Missing argument `options`');
        const items = this._getPageFields();

        return new Field('cmsPage')
            .addArgument('identifier', 'String!', id)
            .addFieldList(items);
    }

    _getPageFields() {
        return [
            'title',
            'content',
            'page_width',
            'content_heading',
            'meta_title',
            'meta_description',
            'meta_keywords'
        ];
    }
}

export default new CmsPageQuery();
