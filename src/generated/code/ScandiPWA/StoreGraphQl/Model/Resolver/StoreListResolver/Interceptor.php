<?php
namespace ScandiPWA\StoreGraphQl\Model\Resolver\StoreListResolver;

/**
 * Interceptor class for @see \ScandiPWA\StoreGraphQl\Model\Resolver\StoreListResolver
 */
class Interceptor extends \ScandiPWA\StoreGraphQl\Model\Resolver\StoreListResolver implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\StoreGraphQl\Model\Resolver\Store\StoreConfigDataProvider $storeConfigsDataProvider, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($storeConfigsDataProvider, $storeManager);
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
