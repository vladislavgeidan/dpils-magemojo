<?php
namespace ScandiPWA\CatalogGraphQl\Model\Resolver\Product;

/**
 * Interceptor class for @see \ScandiPWA\CatalogGraphQl\Model\Resolver\Product
 */
class Interceptor extends \ScandiPWA\CatalogGraphQl\Model\Resolver\Product implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\CatalogGraphQl\Model\Resolver\Products\DataProvider\Deferred\Product $productDataProvider, \Magento\Framework\GraphQl\Query\Resolver\ValueFactory $valueFactory, \Magento\Framework\GraphQl\Query\FieldTranslator $fieldTranslator)
    {
        $this->___init();
        parent::__construct($productDataProvider, $valueFactory, $fieldTranslator);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(\Magento\Framework\GraphQl\Config\Element\Field $field, $context, \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info, ?array $value = null, ?array $args = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        if (!$pluginInfo) {
            return parent::resolve($field, $context, $info, $value, $args);
        } else {
            return $this->___callPlugins('resolve', func_get_args(), $pluginInfo);
        }
    }
}
