<?php
namespace Magento\CatalogInventory\Model\StockState;

/**
 * Interceptor class for @see \Magento\CatalogInventory\Model\StockState
 */
class Interceptor extends \Magento\CatalogInventory\Model\StockState implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\CatalogInventory\Model\Spi\StockStateProviderInterface $stockStateProvider, \Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface $stockRegistryProvider, \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration)
    {
        $this->___init();
        parent::__construct($stockStateProvider, $stockRegistryProvider, $stockConfiguration);
    }

    /**
     * {@inheritdoc}
     */
    public function verifyStock($productId, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'verifyStock');
        if (!$pluginInfo) {
            return parent::verifyStock($productId, $scopeId);
        } else {
            return $this->___callPlugins('verifyStock', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function verifyNotification($productId, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'verifyNotification');
        if (!$pluginInfo) {
            return parent::verifyNotification($productId, $scopeId);
        } else {
            return $this->___callPlugins('verifyNotification', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkQty($productId, $qty, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkQty');
        if (!$pluginInfo) {
            return parent::checkQty($productId, $qty, $scopeId);
        } else {
            return $this->___callPlugins('checkQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function suggestQty($productId, $qty, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'suggestQty');
        if (!$pluginInfo) {
            return parent::suggestQty($productId, $qty, $scopeId);
        } else {
            return $this->___callPlugins('suggestQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStockQty($productId, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStockQty');
        if (!$pluginInfo) {
            return parent::getStockQty($productId, $scopeId);
        } else {
            return $this->___callPlugins('getStockQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkQtyIncrements($productId, $qty, $websiteId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkQtyIncrements');
        if (!$pluginInfo) {
            return parent::checkQtyIncrements($productId, $qty, $websiteId);
        } else {
            return $this->___callPlugins('checkQtyIncrements', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkQuoteItemQty($productId, $itemQty, $qtyToCheck, $origQty, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkQuoteItemQty');
        if (!$pluginInfo) {
            return parent::checkQuoteItemQty($productId, $itemQty, $qtyToCheck, $origQty, $scopeId);
        } else {
            return $this->___callPlugins('checkQuoteItemQty', func_get_args(), $pluginInfo);
        }
    }
}
