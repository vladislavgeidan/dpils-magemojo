<?php
namespace ScandiPWA\MenuOrganizer\Model\ResourceModel\Item;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @category ScandiPWA
 * @package ScandiPWA\MenuOrganizer\Model\ResourceModel\Item
 * @author Dmitrijs Sitovs <info@scandiweb.com / dmitrijssh@scandiweb.com / dsitovs@gmail.com>
 * @copyright Copyright (c) 2015 Scandiweb, Ltd (http://scandiweb.com)
 * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ScandiPWA\MenuOrganizer\Model\Item', 'ScandiPWA\MenuOrganizer\Model\ResourceModel\Item');
    }

    /**
     * Join title for parent items
     */
    public function joinParentNames()
    {
        $select = $this->getSelect();

        $select->joinLeft(
            ['item_table' => $this->getTable('scandiweb_menumanager_item')],
            'main_table.parent_id = item_table.item_id',
            ['parent_title' => 'title']
        )->order('main_table.item_id ASC');

        return $this;
    }

    /**
     * Add menu filter to item collection
     *
     * @param   int | \ScandiPWA\MenuOrganizer\Model\Menu $menu
     * @return  \ScandiPWA\MenuOrganizer\Model\ResourceModel\Item\Collection
     */
    public function addMenuFilter($menu)
    {
        if ($menu instanceof \ScandiPWA\MenuOrganizer\Model\Menu) {
            $menu = $menu->getId();
        }

        $this->addFilter('menu_id', $menu);

        return $this;
    }

    /**
     * Add status filter to item collection
     *
     * @return \ScandiPWA\MenuOrganizer\Model\ResourceModel\Item\Collection
     */
    public function addStatusFilter()
    {
        $this->addFilter('is_active', 1);

        return $this;
    }

    /**
     * Set order to item collection
     *
     * @return \ScandiPWA\MenuOrganizer\Model\ResourceModel\Item\Collection
     */
    public function setPositionOrder()
    {
        $this->setOrder('position', 'asc');

        return $this;
    }

    /**
     * set order by parent id
     *
     * @return \ScandiPWA\MenuOrganizer\Model\ResourceModel\Item\Collection
     */
    public function setParentIdOrder()
    {
        $this->setOrder('parent_id', 'asc');

        return $this;
    }

    /**
     * @param $itemId
     *
     * @return $this
     */
    public function excludeCurrentItem($itemId)
    {
        if ($itemId) {
            $this->addFieldToFilter('item_id', ['nin' => $itemId]);
        }

        return $this;
    }

    /**
     * Collection to option array method
     *
     * @return array
     */
    public function toItemOptionArray()
    {
        $result = [];
        $result['0'] = __('Root');

        foreach ($this as $item) {
            $result[$item->getData('item_id')] = $item->getData('title');
        }

        return $result;
    }

    /**
     * @return $this
     */
    protected function _afterLoadData()
    {
        parent::_afterLoadData();

        $collection = clone $this;
        if (count($collection)) {
            $this->_eventManager->dispatch('scandipwa_menuorganizer_item_collection_load_after', ['collection' => $collection]);
        }

        return $this;
    }
}
