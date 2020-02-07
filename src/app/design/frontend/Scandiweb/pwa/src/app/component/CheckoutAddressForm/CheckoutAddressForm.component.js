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
import FormPortal from 'Component/FormPortal';
import { debounce } from 'Util/Request';
import MyAccountAddressForm from 'Component/MyAccountAddressForm/MyAccountAddressForm.component';
import './CheckoutAddressForm.style';

export const UPDATE_STATE_FREQUENCY = 1000; // (ms)

class CheckoutAddressForm extends MyAccountAddressForm {
    static propTypes = {
        ...MyAccountAddressForm.propTypes,
        id: PropTypes.string.isRequired,
        onShippingEstimationFieldsChange: PropTypes.func
    };

    static defaultProps = {
        ...MyAccountAddressForm.defaultProps,
        onShippingEstimationFieldsChange: () => {}
    };

    onChange = debounce((key, value) => {
        this.setState(() => ({ [key]: value }));
    }, UPDATE_STATE_FREQUENCY);

    constructor(props) {
        super(props);

        const {
            address: { region: { region = '' } = {} }
        } = this.props;

        // TODO: get from region data
        this.state = {
            ...this.state,
            region,
            city: '',
            postcode: ''
        };

        this.estimateShipping();
    }

    componentDidUpdate(_, prevState) {
        const {
            countryId,
            regionId,
            region,
            city,
            postcode
        } = this.state;

        const {
            countryId: prevCountryId,
            regionId: prevRegionId,
            region: prevRegion,
            city: prevCity,
            postcode: prevpostcode
        } = prevState;

        if (
            countryId !== prevCountryId
            || regionId !== prevRegionId
            || city !== prevCity
            || region !== prevRegion
            || postcode !== prevpostcode
        ) {
            this.estimateShipping();
        }
    }

    estimateShipping() {
        const { onShippingEstimationFieldsChange } = this.props;

        const {
            countryId,
            regionId,
            region,
            city,
            postcode
        } = this.state;

        onShippingEstimationFieldsChange({
            country_id: countryId,
            region_id: regionId,
            region,
            city,
            postcode
        });
    }

    get fieldMap() {
        // country_id, region, region_id, city - are used for shipping estimation

        const {
            default_billing,
            default_shipping,
            city,
            postcode,
            ...fieldMap
        } = super.fieldMap;

        fieldMap.city = {
            ...city,
            onChange: value => this.onChange('city', value)
        };

        fieldMap.postcode = {
            ...postcode,
            onChange: value => this.onChange('postcode', value)
        };

        return fieldMap;
    }

    getRegionFields() {
        const regionFieldData = super.getRegionFields();
        const { region_string } = regionFieldData;

        if (region_string) {
            regionFieldData.region_string.onChange = v => this.onChange('region', v);
        }

        return regionFieldData;
    }

    render() {
        const { id } = this.props;

        return (
            <FormPortal
              id={ id }
              name="CheckoutAddressForm"
            >
                <div
                  block="FieldForm"
                  mix={ { block: 'CheckoutAddressForm' } }
                >
                    { this.renderFields() }
                </div>
            </FormPortal>
        );
    }
}

export default CheckoutAddressForm;
