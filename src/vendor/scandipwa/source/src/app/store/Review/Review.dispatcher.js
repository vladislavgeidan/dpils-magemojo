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

import { showNotification } from 'Store/Notification';
import { fetchMutation } from 'Util/Request';
import { ReviewQuery } from 'Query';

/**
 * Product Review Dispatcher
 * @class WishlistDispatcher
 */
export class ReviewDispatcher {
    prepareRatingData(reviewItem) {
        const { rating_data } = reviewItem;

        return Object.keys(rating_data).map(
            key => ({
                rating_id: +key,
                option_id: rating_data[key]
            })
        );
    }

    submitProductReview(dispatch, options) {
        const reviewItem = options;

        reviewItem.rating_data = this.prepareRatingData(reviewItem);

        return fetchMutation(ReviewQuery.getAddProductReviewMutation(
            reviewItem
        )).then(
            () => dispatch(showNotification('success', 'You submitted your review for moderation.')),
            // eslint-disable-next-line no-console
            error => dispatch(showNotification('error', 'Error submitting review!')) && console.log(error)
        );
    }
}

export default new ReviewDispatcher();
