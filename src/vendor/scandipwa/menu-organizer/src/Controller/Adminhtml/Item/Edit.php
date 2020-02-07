<?php
namespace ScandiPWA\MenuOrganizer\Controller\Adminhtml\Item;

use Magento\Backend\App\Action;

/**
 * @category ScandiPWA
 * @package ScandiPWA\MenuOrganizer\Controller\Adminhtml\Item
 * @author Dmitrijs Sitovs <info@scandiweb.com / dmitrijssh@scandiweb.com / dsitovs@gmail.com>
 * @copyright Copyright (c) 2015 Scandiweb, Ltd (http://scandiweb.com)
 * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *
 * Class Edit
 */
class Edit extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'ScandiPWA_MenuOrganizer::navigation_menu_item_save';

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_registry = null;

    protected $_menumanagerHelper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    )
    {
        parent::__construct($context);
        $this->_registry = $registry;
        $this->resultLayoutFactory = $resultLayoutFactory;
    }

    /**
     * Load item by ID from get parameter
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            return $this->_redirect('*/menu/index');
        }

        $itemId = $this->getRequest()->getParam('item_id');
        $item = $this->_objectManager->create('ScandiPWA\MenuOrganizer\Model\Item');

        if ($itemId) {
            $item->load($itemId);

            if (!$this->_validateItem($item) || !$this->_validateMenu($item)) {
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/menu/index/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);

        if (!empty($data)) {
            $item->setData($data);
        }

        $this->_registry->register('scandipwa_menuorganizer_item', $item);

        $resultLayout = $this->resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('scandipwa_menuorganizer_item_edit');

        return $resultLayout;
    }

    /**
     * @param \ScandiPWA\MenuOrganizer\Model\Item $item
     *
     * @return bool
     */
    protected function _validateMenu(\ScandiPWA\MenuOrganizer\Model\Item $item)
    {
        $menuId = $this->getRequest()->getParam('menu_id');

        if (!$item->getMenuId() || $item->getMenuId() !== $menuId) {
            $this->messageManager->addError(__('There was an error during menu validation.'));

            return false;
        }

        return true;
    }

    /**
     * @param \ScandiPWA\MenuOrganizer\Model\Item $item
     *
     * @return bool
     */
    protected function _validateItem(\ScandiPWA\MenuOrganizer\Model\Item $item)
    {
        if (!$item->getId()) {
            $this->messageManager->addError(__('This item no longer exists.'));
            /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */

            return false;
        }

        return true;
    }
}
