import { PureComponent } from 'react';
import PropTypes from 'prop-types';
import { AttributeType } from 'Type/ProductList';
import ProductConfigurableAttributeDropdown from './ProductConfigurableAttributeDropdown.component';

class ProductConfigurableAttributeDropdownContainer extends PureComponent {
    static propTypes = {
        option: AttributeType.isRequired,
        updateConfigurableVariant: PropTypes.func.isRequired,
        getIsConfigurableAttributeAvailable: PropTypes.func.isRequired,
        parameters: PropTypes.objectOf(PropTypes.string).isRequired
    };

    containerFunctions = {
        onChange: this.onChange.bind(this)
    };


    onChange(value) {
        const {
            updateConfigurableVariant,
            option: { attribute_code }
        } = this.props;

        updateConfigurableVariant(attribute_code, value);
    }

    containerProps = () => {
        const { option: { attribute_code, attribute_label } } = this.props;

        return {
            selectValue: this._getSelectValue(),
            selectOptions: this._getSelectOptions(),
            selectName: attribute_code,
            selectLabel: attribute_label
        };
    };

    _getSelectOptions = () => {
        const {
            option: {
                attribute_options,
                attribute_code
            },
            getIsConfigurableAttributeAvailable
        } = this.props;

        return Object.values(attribute_options)
            .reduce((acc, option) => {
                const { value } = option;

                const isAvailable = getIsConfigurableAttributeAvailable({
                    attribute_code,
                    attribute_value: value
                });

                if (!isAvailable) return acc;

                return [...acc, {
                    ...option,
                    id: value
                }];
            }, []);
    };

    _getSelectValue = () => {
        const { option: { attribute_code } } = this.props;
        const { parameters = {} } = this.props;
        return parameters[attribute_code];
    };

    render() {
        return (
            <ProductConfigurableAttributeDropdown
              { ...this.props }
              { ...this.containerFunctions }
              { ...this.containerProps() }
            />
        );
    }
}

export default ProductConfigurableAttributeDropdownContainer;
