<?php
namespace ScandiPWA\CatalogGraphQl\Model\Resolver\Inventory\StockCount;

/**
 * Interceptor class for @see \ScandiPWA\CatalogGraphQl\Model\Resolver\Inventory\StockCount
 */
class Interceptor extends \ScandiPWA\CatalogGraphQl\Model\Resolver\Inventory\StockCount implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\CatalogInventory\Api\StockStatusRepositoryInterface $stockStatusRepository)
    {
        $this->___init();
        parent::__construct($stockStatusRepository);
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
