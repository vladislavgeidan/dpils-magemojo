<?php
namespace Magento\CatalogInventory\Helper\Stock;

/**
 * Interceptor class for @see \Magento\CatalogInventory\Helper\Stock
 */
class Interceptor extends \Magento\CatalogInventory\Helper\Stock implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\CatalogInventory\Model\ResourceModel\Stock\StatusFactory $stockStatusFactory, \Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface $stockRegistryProvider)
    {
        $this->___init();
        parent::__construct($storeManager, $scopeConfig, $stockStatusFactory, $stockRegistryProvider);
    }

    /**
     * {@inheritdoc}
     */
    public function assignStatusToProduct(\Magento\Catalog\Model\Product $product, $status = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'assignStatusToProduct');
        if (!$pluginInfo) {
            return parent::assignStatusToProduct($product, $status);
        } else {
            return $this->___callPlugins('assignStatusToProduct', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addStockStatusToProducts(\Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection $productCollection)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addStockStatusToProducts');
        if (!$pluginInfo) {
            return parent::addStockStatusToProducts($productCollection);
        } else {
            return $this->___callPlugins('addStockStatusToProducts', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addInStockFilterToCollection($collection)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addInStockFilterToCollection');
        if (!$pluginInfo) {
            return parent::addInStockFilterToCollection($collection);
        } else {
            return $this->___callPlugins('addInStockFilterToCollection', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addIsInStockFilterToCollection($collection)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addIsInStockFilterToCollection');
        if (!$pluginInfo) {
            return parent::addIsInStockFilterToCollection($collection);
        } else {
            return $this->___callPlugins('addIsInStockFilterToCollection', func_get_args(), $pluginInfo);
        }
    }
}
