<?php
namespace Magento\Framework\Mail\Template\TransportBuilder;

/**
 * Interceptor class for @see \Magento\Framework\Mail\Template\TransportBuilder
 */
class Interceptor extends \Magento\Framework\Mail\Template\TransportBuilder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Mail\Template\FactoryInterface $templateFactory, \Magento\Framework\Mail\MessageInterface $message, \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\Mail\TransportInterfaceFactory $mailTransportFactory, ?\Magento\Framework\Mail\MessageInterfaceFactory $messageFactory = null, ?\Magento\Framework\Mail\EmailMessageInterfaceFactory $emailMessageInterfaceFactory = null, ?\Magento\Framework\Mail\MimeMessageInterfaceFactory $mimeMessageInterfaceFactory = null, ?\Magento\Framework\Mail\MimePartInterfaceFactory $mimePartInterfaceFactory = null, ?\Magento\Framework\Mail\AddressConverter $addressConverter = null)
    {
        $this->___init();
        parent::__construct($templateFactory, $message, $senderResolver, $objectManager, $mailTransportFactory, $messageFactory, $emailMessageInterfaceFactory, $mimeMessageInterfaceFactory, $mimePartInterfaceFactory, $addressConverter);
    }

    /**
     * {@inheritdoc}
     */
    public function addCc($address, $name = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addCc');
        if (!$pluginInfo) {
            return parent::addCc($address, $name);
        } else {
            return $this->___callPlugins('addCc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addTo($address, $name = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addTo');
        if (!$pluginInfo) {
            return parent::addTo($address, $name);
        } else {
            return $this->___callPlugins('addTo', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addBcc($address)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addBcc');
        if (!$pluginInfo) {
            return parent::addBcc($address);
        } else {
            return $this->___callPlugins('addBcc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setReplyTo($email, $name = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setReplyTo');
        if (!$pluginInfo) {
            return parent::setReplyTo($email, $name);
        } else {
            return $this->___callPlugins('setReplyTo', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom($from)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setFrom');
        if (!$pluginInfo) {
            return parent::setFrom($from);
        } else {
            return $this->___callPlugins('setFrom', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setFromByScope($from, $scopeId = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setFromByScope');
        if (!$pluginInfo) {
            return parent::setFromByScope($from, $scopeId);
        } else {
            return $this->___callPlugins('setFromByScope', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplateIdentifier($templateIdentifier)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setTemplateIdentifier');
        if (!$pluginInfo) {
            return parent::setTemplateIdentifier($templateIdentifier);
        } else {
            return $this->___callPlugins('setTemplateIdentifier', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplateModel($templateModel)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setTemplateModel');
        if (!$pluginInfo) {
            return parent::setTemplateModel($templateModel);
        } else {
            return $this->___callPlugins('setTemplateModel', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplateVars($templateVars)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setTemplateVars');
        if (!$pluginInfo) {
            return parent::setTemplateVars($templateVars);
        } else {
            return $this->___callPlugins('setTemplateVars', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplateOptions($templateOptions)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setTemplateOptions');
        if (!$pluginInfo) {
            return parent::setTemplateOptions($templateOptions);
        } else {
            return $this->___callPlugins('setTemplateOptions', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTransport()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTransport');
        if (!$pluginInfo) {
            return parent::getTransport();
        } else {
            return $this->___callPlugins('getTransport', func_get_args(), $pluginInfo);
        }
    }
}
