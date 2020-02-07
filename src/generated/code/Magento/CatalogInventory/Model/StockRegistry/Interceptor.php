<?php
namespace Magento\CatalogInventory\Model\StockRegistry;

/**
 * Interceptor class for @see \Magento\CatalogInventory\Model\StockRegistry
 */
class Interceptor extends \Magento\CatalogInventory\Model\StockRegistry implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration, \Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface $stockRegistryProvider, \Magento\CatalogInventory\Api\StockItemRepositoryInterface $stockItemRepository, \Magento\CatalogInventory\Api\StockItemCriteriaInterfaceFactory $criteriaFactory, \Magento\Catalog\Model\ProductFactory $productFactory)
    {
        $this->___init();
        parent::__construct($stockConfiguration, $stockRegistryProvider, $stockItemRepository, $criteriaFactory, $productFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getStock($scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStock');
        if (!$pluginInfo) {
            return parent::getStock($scopeId);
        } else {
            return $this->___callPlugins('getStock', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStockItem($productId, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStockItem');
        if (!$pluginInfo) {
            return parent::getStockItem($productId, $scopeId);
        } else {
            return $this->___callPlugins('getStockItem', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStockItemBySku($productSku, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStockItemBySku');
        if (!$pluginInfo) {
            return parent::getStockItemBySku($productSku, $scopeId);
        } else {
            return $this->___callPlugins('getStockItemBySku', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStockStatus($productId, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStockStatus');
        if (!$pluginInfo) {
            return parent::getStockStatus($productId, $scopeId);
        } else {
            return $this->___callPlugins('getStockStatus', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStockStatusBySku($productSku, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStockStatusBySku');
        if (!$pluginInfo) {
            return parent::getStockStatusBySku($productSku, $scopeId);
        } else {
            return $this->___callPlugins('getStockStatusBySku', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductStockStatus($productId, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductStockStatus');
        if (!$pluginInfo) {
            return parent::getProductStockStatus($productId, $scopeId);
        } else {
            return $this->___callPlugins('getProductStockStatus', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductStockStatusBySku($productSku, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductStockStatusBySku');
        if (!$pluginInfo) {
            return parent::getProductStockStatusBySku($productSku, $scopeId);
        } else {
            return $this->___callPlugins('getProductStockStatusBySku', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLowStockItems($scopeId, $qty, $currentPage = 1, $pageSize = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLowStockItems');
        if (!$pluginInfo) {
            return parent::getLowStockItems($scopeId, $qty, $currentPage, $pageSize);
        } else {
            return $this->___callPlugins('getLowStockItems', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateStockItemBySku($productSku, \Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'updateStockItemBySku');
        if (!$pluginInfo) {
            return parent::updateStockItemBySku($productSku, $stockItem);
        } else {
            return $this->___callPlugins('updateStockItemBySku', func_get_args(), $pluginInfo);
        }
    }
}
