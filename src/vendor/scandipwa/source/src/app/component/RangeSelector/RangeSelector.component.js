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
import InputRange from 'react-input-range';
import PropTypes from 'prop-types';
import 'react-input-range/lib/css/index.css';
import './RangeSelector.style';

/**
 * Product Sort
 * @class ProductSort
 */
export default class RangeSelector extends PureComponent {
    static propTypes = {
        value: PropTypes.oneOfType([
            PropTypes.object,
            PropTypes.number
        ]).isRequired,
        minValue: PropTypes.number.isRequired,
        maxValue: PropTypes.number.isRequired,
        onChangeComplete: PropTypes.func.isRequired
    };

    constructor() {
        super();

        this.state = {
            value: false
        };
    }

    onChange = (value) => {
        this.setState({ value });
    };

    /**
     * Toggle on range selection change
     * @param {Object} value sliders mix and max values
     * @return {void}
     */
    onChangeComplete = (value) => {
        const { onChangeComplete } = this.props;

        onChangeComplete(value);

        this.setState({ value: false });
    };

    /**
     * Get selected value
     * @return {Number}
     */
    getValue() {
        const { value: stateValue } = this.state;
        const { value } = this.props;
        const currentValue = stateValue || value;

        return this.limitValueToBounds(currentValue);
    }

    /**
     * Limit selected value to min and max bounds
     * @param {Object} value sliders mix and max values
     * @return {Number} value within bounds
     */
    limitValueToBounds(value) {
        const { minValue, maxValue } = this.props;
        const newValue = { ...value };

        if (newValue.max > maxValue) newValue.max = maxValue;
        if (newValue.min < minValue) newValue.min = minValue;

        return newValue;
    }

    render() {
        const { minValue, maxValue } = this.props;
        const { min, max } = this.getValue();
        const isChanged = min !== minValue || max !== maxValue;

        return (
            <div block="RangeSelector" mods={ { isChanged } }>
                <InputRange
                  minValue={ minValue }
                  maxValue={ maxValue }
                  value={ this.getValue() }
                  onChangeComplete={ this.onChangeComplete }
                  onChange={ this.onChange }
                />
            </div>
        );
    }
}
