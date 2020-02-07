<?php
namespace ScandiPWA\MenuOrganizer\Model\Resolver\Menu;

/**
 * Interceptor class for @see \ScandiPWA\MenuOrganizer\Model\Resolver\Menu
 */
class Interceptor extends \ScandiPWA\MenuOrganizer\Model\Resolver\Menu implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager, \ScandiPWA\MenuOrganizer\Model\MenuFactory $menuFactory, \ScandiPWA\MenuOrganizer\Model\ResourceModel\Menu $menuResourceModel, \ScandiPWA\MenuOrganizer\Model\ResourceModel\Item\CollectionFactory $itemCollectionFactory, \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository)
    {
        $this->___init();
        parent::__construct($storeManager, $menuFactory, $menuResourceModel, $itemCollectionFactory, $categoryRepository);
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
