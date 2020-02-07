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
import PropTypes from 'prop-types';
import './ReviewStar.style';

export default class ReviewStar extends PureComponent {
    static propTypes = {
        value: PropTypes.number.isRequired,
        name: PropTypes.number.isRequired,
        title: PropTypes.string.isRequired,
        isChecked: PropTypes.bool.isRequired,
        option_id: PropTypes.number.isRequired,
        rating_id: PropTypes.number.isRequired,
        onStarRatingClick: PropTypes.func.isRequired
    };

    onStarRatingClick = () => {
        const {
            rating_id,
            option_id,
            onStarRatingClick
        } = this.props;

        onStarRatingClick(rating_id, option_id);
    };

    render() {
        const {
            name,
            value,
            title,
            isChecked,
            rating_id,
            option_id
        } = this.props;

        return (
            <input
              block="ReviewStar"
              type="radio"
              id={ option_id + rating_id }
              name={ name }
              value={ value }
              title={ title }
              checked={ isChecked }
              onChange={ this.onStarRatingClick }
            />
        );
    }
}
