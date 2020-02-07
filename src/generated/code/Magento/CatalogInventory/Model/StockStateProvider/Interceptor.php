<?php
namespace Magento\CatalogInventory\Model\StockStateProvider;

/**
 * Interceptor class for @see \Magento\CatalogInventory\Model\StockStateProvider
 */
class Interceptor extends \Magento\CatalogInventory\Model\StockStateProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Math\Division $mathDivision, \Magento\Framework\Locale\FormatInterface $localeFormat, \Magento\Framework\DataObject\Factory $objectFactory, \Magento\Catalog\Model\ProductFactory $productFactory, $qtyCheckApplicable = true)
    {
        $this->___init();
        parent::__construct($mathDivision, $localeFormat, $objectFactory, $productFactory, $qtyCheckApplicable);
    }

    /**
     * {@inheritdoc}
     */
    public function verifyStock(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'verifyStock');
        if (!$pluginInfo) {
            return parent::verifyStock($stockItem);
        } else {
            return $this->___callPlugins('verifyStock', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function verifyNotification(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'verifyNotification');
        if (!$pluginInfo) {
            return parent::verifyNotification($stockItem);
        } else {
            return $this->___callPlugins('verifyNotification', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkQuoteItemQty(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem, $qty, $summaryQty, $origQty = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkQuoteItemQty');
        if (!$pluginInfo) {
            return parent::checkQuoteItemQty($stockItem, $qty, $summaryQty, $origQty);
        } else {
            return $this->___callPlugins('checkQuoteItemQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkQty(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem, $qty)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkQty');
        if (!$pluginInfo) {
            return parent::checkQty($stockItem, $qty);
        } else {
            return $this->___callPlugins('checkQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function suggestQty(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem, $qty)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'suggestQty');
        if (!$pluginInfo) {
            return parent::suggestQty($stockItem, $qty);
        } else {
            return $this->___callPlugins('suggestQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkQtyIncrements(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem, $qty)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkQtyIncrements');
        if (!$pluginInfo) {
            return parent::checkQtyIncrements($stockItem, $qty);
        } else {
            return $this->___callPlugins('checkQtyIncrements', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStockQty(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStockQty');
        if (!$pluginInfo) {
            return parent::getStockQty($stockItem);
        } else {
            return $this->___callPlugins('getStockQty', func_get_args(), $pluginInfo);
        }
    }
}
