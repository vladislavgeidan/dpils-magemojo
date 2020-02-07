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

import { customerType } from 'Type/Account';
import { RatingItemsType } from 'Type/Rating';
import { ProductType } from 'Type/ProductList';
import { ReviewDispatcher } from 'Store/Review';
import { hideActiveOverlay } from 'Store/Overlay';
import { showNotification } from 'Store/Notification';
import { goToPreviousNavigationState } from 'Store/Navigation';
import { TOP_NAVIGATION_TYPE } from 'Store/Navigation/Navigation.reducer';

import ProductReviewForm from './ProductReviewForm.component';

export const mapStateToProps = state => ({
    customer: state.MyAccountReducer.customer,
    isSignedIn: state.MyAccountReducer.isSignedIn,
    reviewRatings: state.ConfigReducer.reviewRatings
});

export const mapDispatchToProps = dispatch => ({
    addReview: options => ReviewDispatcher.submitProductReview(dispatch, options),
    showNotification: (type, message) => dispatch(showNotification(type, message)),
    hideActiveOverlay: () => dispatch(hideActiveOverlay()),
    goToPreviousHeaderState: () => dispatch(goToPreviousNavigationState(TOP_NAVIGATION_TYPE))
});

export class ProductReviewFormContainer extends PureComponent {
    static propTypes = {
        showNotification: PropTypes.func.isRequired,
        goToPreviousHeaderState: PropTypes.func.isRequired,
        hideActiveOverlay: PropTypes.func.isRequired,
        reviewRatings: RatingItemsType.isRequired,
        product: ProductType.isRequired,
        addReview: PropTypes.func.isRequired,
        customer: customerType.isRequired
    };

    containerFunctions = ({
        onReviewSubmitAttempt: this._onReviewSubmitAttempt.bind(this),
        onReviewSubmitSuccess: this._onReviewSubmitSuccess.bind(this),
        onStarRatingClick: this._onStarRatingClick.bind(this),
        handleNicknameChange: this._handleFieldChange.bind(this, 'nickname'),
        handleSummaryChange: this._handleFieldChange.bind(this, 'summary'),
        handleDetailChange: this._handleFieldChange.bind(this, 'detail'),
        onReviewError: this._onReviewError.bind(this)
    });

    constructor(props) {
        super(props);

        const { customer: { firstname: nickname } } = this.props;
        const reviewData = { nickname };

        this.state = {
            isLoading: false,
            ratingData: {},
            reviewData
        };
    }

    _onReviewError() {
        this.setState({ isLoading: false });
    }

    _onReviewSubmitAttempt(_, invalidFields) {
        const { showNotification, reviewRatings } = this.props;
        const { ratingData } = this.state;

        const reviewsAreNotValid = invalidFields
            || !reviewRatings.every(({ rating_id }) => ratingData[rating_id]);

        if (reviewsAreNotValid) {
            showNotification('info', 'Incorrect data! Please check review fields.');
        }

        this.setState({ isLoading: !reviewsAreNotValid });
    }

    _onReviewSubmitSuccess(fields) {
        const {
            product,
            addReview,
            hideActiveOverlay,
            goToPreviousHeaderState
        } = this.props;

        const { ratingData: rating_data, isLoading } = this.state;

        const {
            nickname,
            title,
            detail
        } = fields;

        const { sku: product_sku } = product;

        if (Object.keys(rating_data).length && isLoading) {
            addReview({
                nickname,
                title,
                detail,
                product_sku,
                rating_data
            }).then((success) => {
                if (success) {
                    this.setState({
                        ratingData: {},
                        reviewData: {},
                        isLoading: false
                    });

                    goToPreviousHeaderState();
                    hideActiveOverlay();

                    return;
                }

                this.setState({ isLoading: false });
            });
        }
    }

    _onStarRatingClick(rating_id, option_id) {
        this.setState(({ ratingData }) => ({
            ratingData: { ...ratingData, [rating_id]: option_id }
        }));
    }

    _handleFieldChange(fieldName, value) {
        this.setState(({ reviewData }) => ({
            reviewData: { ...reviewData, [fieldName]: value }
        }));
    }

    render() {
        return (
            <ProductReviewForm
              { ...this.props }
              { ...this.containerFunctions }
              { ...this.state }
            />
        );
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ProductReviewFormContainer);
