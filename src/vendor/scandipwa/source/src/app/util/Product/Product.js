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


/**
 * Checks whether every option is in attributes
 * @param {Object} attributes
 * @param {{ attribute_code: string }[]} options
 * @returns {boolean}
 */
export const checkEveryOption = (attributes, options) => Object.keys(options)
    .every((option) => {
        if (!attributes[option]) return false;

        const { attribute_value } = attributes[option];
        if (typeof options[option] === 'string') {
            return options[option] === attribute_value;
        }

        return options[option].includes(attribute_value);
    });

export const getIndexedAttributeOption = (option) => {
    const { swatch_data: defaultSwatchData } = option;
    if (!defaultSwatchData) return option;

    const { type } = defaultSwatchData;
    const swatch_data = type ? defaultSwatchData : null;

    return {
        ...option,
        swatch_data
    };
};

export const getIndexedAttributes = attributes => attributes.reduce((indexedAttributes, attribute) => {
    const { attribute_code, attribute_options = [] } = attribute;

    return {
        ...indexedAttributes,
        [attribute_code]: {
            ...attribute,
            attribute_options: attribute_options.reduce((acc, option) => {
                const { value } = option;

                return {
                    ...acc,
                    [value]: getIndexedAttributeOption(option)
                };
            }, {})
        }
    };
}, {});

export const getIndexedConfigurableOptions = (configurableOptions, indexedAttributes) => (
    configurableOptions.reduce((indexedConfigurableOptions, configurableOption) => {
        const { values, attribute_code } = configurableOption;

        return {
            ...indexedConfigurableOptions,
            [attribute_code]: {
                ...configurableOption,
                ...indexedAttributes[attribute_code],
                attribute_values: values.map(({ value_index }) => `${ value_index }`)
            }
        };
    }, {})
);

export const getIndexedVariants = variants => variants.map(({ product }) => {
    const { attributes } = product;
    return {
        ...product,
        attributes: getIndexedAttributes(attributes || [])
    };
});

/**
 * Get product variant index by options
 * @param {Object[]} variants
 * @param {{ attribute_code: string }[]} options
 * @returns {number}
 */
export const getVariantIndex = (variants, options) => variants
    .findIndex(variant => checkEveryOption(variant.attributes, options));

export const getVariantsIndexes = (variants, options) => Object.entries(variants)
    .reduce((indexes, [index, variant]) => {
        if (checkEveryOption(variant.attributes, options)) indexes.push(+index);
        return indexes;
    }, []);

export const getIndexedProduct = (product) => {
    const {
        variants: initialVariants = [],
        configurable_options: initialConfigurableOptions = [],
        attributes: initialAttributes = []
    } = product;

    const attributes = getIndexedAttributes(initialAttributes || []);

    return {
        ...product,
        configurable_options: getIndexedConfigurableOptions(initialConfigurableOptions, attributes),
        variants: getIndexedVariants(initialVariants),
        attributes
    };
};

export const getIndexedProducts = products => products.map(getIndexedProduct);

export const getIndexedParameteredProducts = products => Object.entries(products)
    .reduce((products, [id, product]) => ({
        ...products,
        [id]: getIndexedProduct(product)
    }), {});


export const getExtensionAttributes = (product) => {
    const {
        configurable_options,
        configurableVariantIndex,
        variants,
        type_id
    } = product;

    if (type_id === 'configurable') {
        const { attributes = {} } = variants[configurableVariantIndex] || {};

        const configurable_item_options = Object.values(configurable_options)
            .reduce((prev, { attribute_id, attribute_code }) => {
                const { attribute_value } = attributes[attribute_code] || {};

                if (attribute_value) {
                    return [
                        ...prev,
                        {
                            option_id: attribute_id,
                            option_value: attribute_value
                        }
                    ];
                }

                return prev;
            }, []);

        return { configurable_item_options };
    }

    return {};
};
