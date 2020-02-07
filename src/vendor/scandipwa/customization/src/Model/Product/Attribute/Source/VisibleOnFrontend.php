<?php
/**
 * @category ScandiPWA
 * @package ScandiPWA\Customization
 * @author Alfreds Genkins <info@scandiweb.com>
 * @copyright Copyright (c) 2015 Scandiweb, Ltd (http://scandiweb.com)
 * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

namespace ScandiPWA\Customization\Model\Product\Attribute\Source;

use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class VisibleOnFrontend extends AbstractSource
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * FilterableAttributeList constructor
     *
     * @param CollectionFactory $collectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * Retrieve All options
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $attributes = $this->collectionFactory
                ->create()
                ->setItemObjectClass(Attribute::class)
                ->addStoreLabel($this->storeManager->getStore()->getId())
                ->setOrder('position', 'ASC')
                ->addFieldToFilter('additional_table.is_visible_on_front', ['gt' => 0])
                ->load()
                ->getItems();

            /** @var Attribute $attribute */
            foreach ($attributes as $attribute) {
                $this->_options[] = [
                    'value' => $attribute->getAttributeCode(),
                    'label' => $attribute->getStoreLabel()
                ];
            }

            array_unshift($this->_options, ['value' => '', 'label' => __('Please select an attribute.')]);
        }

        return $this->_options;
    }
}
