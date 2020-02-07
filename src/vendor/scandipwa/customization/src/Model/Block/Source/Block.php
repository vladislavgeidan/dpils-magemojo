<?php
/**
 * @category ScandiPWA
 * @package ScandiPWA\Customization
 * @author Alfreds Genkins <info@scandiweb.com>
 * @copyright Copyright (c) 2015 Scandiweb, Ltd (http://scandiweb.com)
 * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

namespace ScandiPWA\Customization\Model\Block\Source;

use Magento\Cms\Model\ResourceModel\Block\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Cms\Api\Data\BlockInterface;

/**
 * Class Block
 * @package ScandiPWA\Customization\Model\Block\Source
 */
class Block extends AbstractSource
{
    /**
     * Block collection factory
     *
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Construct
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $blocks = $this->collectionFactory
                ->create()
                ->addFieldToFilter(BlockInterface::IS_ACTIVE, ['eq' => 1])
                ->load()
                ->getItems();

            /** @var BlockInterface $block */
            foreach ($blocks as $block) {
                $this->_options[] = [
                    'value' => $block->getIdentifier(),
                    'label' => $block->getTitle()
                ];
            }

            array_unshift($this->_options, ['value' => '', 'label' => __('Please select a static block.')]);
        }

        return $this->_options;
    }
}
