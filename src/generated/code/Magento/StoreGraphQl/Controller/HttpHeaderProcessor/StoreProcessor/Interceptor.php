<?php
namespace Magento\StoreGraphQl\Controller\HttpHeaderProcessor\StoreProcessor;

/**
 * Interceptor class for @see \Magento\StoreGraphQl\Controller\HttpHeaderProcessor\StoreProcessor
 */
class Interceptor extends \Magento\StoreGraphQl\Controller\HttpHeaderProcessor\StoreProcessor implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Http\Context $httpContext, \Magento\Store\Api\StoreCookieManagerInterface $storeCookieManager)
    {
        $this->___init();
        parent::__construct($storeManager, $httpContext, $storeCookieManager);
    }

    /**
     * {@inheritdoc}
     */
    public function processHeaderValue(string $headerValue) : void
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'processHeaderValue');
        if (!$pluginInfo) {
            parent::processHeaderValue($headerValue);
        } else {
            $this->___callPlugins('processHeaderValue', func_get_args(), $pluginInfo);
        }
    }
}
