<?php
namespace MSP\ReCaptcha\Model\LayoutSettings;

/**
 * Interceptor class for @see \MSP\ReCaptcha\Model\LayoutSettings
 */
class Interceptor extends \MSP\ReCaptcha\Model\LayoutSettings implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\MSP\ReCaptcha\Model\Config $config)
    {
        $this->___init();
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function getCaptchaSettings()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCaptchaSettings');
        if (!$pluginInfo) {
            return parent::getCaptchaSettings();
        } else {
            return $this->___callPlugins('getCaptchaSettings', func_get_args(), $pluginInfo);
        }
    }
}
