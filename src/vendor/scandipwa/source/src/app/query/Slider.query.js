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
 * Slider Query
 * @class Slider
 */
export class Slider {
    getQuery(options) {
        const { sliderId } = options;

        return new Field('scandiwebSlider')
            .addArgument('id', 'ID!', sliderId)
            .addFieldList(this._getSliderFields())
            .setAlias('slider');
    }

    _getSliderFields() {
        return [
            this._getSlidesField(),
            'slider_id',
            'title'
        ];
    }

    _getSlideFields() {
        return [
            'slide_text',
            'slide_id',
            'image',
            'title',
            'is_active'
        ];
    }

    _getSlidesField() {
        return new Field('slides')
            .addFieldList(this._getSlideFields());
    }
}

export default new Slider();
