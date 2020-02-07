<?php
namespace ScandiPWA\ReviewsGraphQl\Model\Resolver\GetRatings;

/**
 * Interceptor class for @see \ScandiPWA\ReviewsGraphQl\Model\Resolver\GetRatings
 */
class Interceptor extends \ScandiPWA\ReviewsGraphQl\Model\Resolver\GetRatings implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Review\Model\ResourceModel\Rating\CollectionFactory $ratingCollectionFactory, \Magento\Review\Model\ResourceModel\Rating\Collection $ratingCollection)
    {
        $this->___init();
        parent::__construct($storeManager, $ratingCollectionFactory, $ratingCollection);
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
