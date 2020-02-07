<?php
namespace Magento\Framework\Mail\Message;

/**
 * Interceptor class for @see \Magento\Framework\Mail\Message
 */
class Interceptor extends \Magento\Framework\Mail\Message implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct($charset = 'utf-8')
    {
        $this->___init();
        parent::__construct($charset);
    }

    /**
     * {@inheritdoc}
     */
    public function setMessageType($type)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setMessageType');
        if (!$pluginInfo) {
            return parent::setMessageType($type);
        } else {
            return $this->___callPlugins('setMessageType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setBody($body)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setBody');
        if (!$pluginInfo) {
            return parent::setBody($body);
        } else {
            return $this->___callPlugins('setBody', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject($subject)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setSubject');
        if (!$pluginInfo) {
            return parent::setSubject($subject);
        } else {
            return $this->___callPlugins('setSubject', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSubject');
        if (!$pluginInfo) {
            return parent::getSubject();
        } else {
            return $this->___callPlugins('getSubject', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBody');
        if (!$pluginInfo) {
            return parent::getBody();
        } else {
            return $this->___callPlugins('getBody', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom($fromAddress)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setFrom');
        if (!$pluginInfo) {
            return parent::setFrom($fromAddress);
        } else {
            return $this->___callPlugins('setFrom', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setFromAddress($fromAddress, $fromName = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setFromAddress');
        if (!$pluginInfo) {
            return parent::setFromAddress($fromAddress, $fromName);
        } else {
            return $this->___callPlugins('setFromAddress', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addTo($toAddress)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addTo');
        if (!$pluginInfo) {
            return parent::addTo($toAddress);
        } else {
            return $this->___callPlugins('addTo', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addCc($ccAddress)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addCc');
        if (!$pluginInfo) {
            return parent::addCc($ccAddress);
        } else {
            return $this->___callPlugins('addCc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addBcc($bccAddress)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addBcc');
        if (!$pluginInfo) {
            return parent::addBcc($bccAddress);
        } else {
            return $this->___callPlugins('addBcc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setReplyTo($replyToAddress)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setReplyTo');
        if (!$pluginInfo) {
            return parent::setReplyTo($replyToAddress);
        } else {
            return $this->___callPlugins('setReplyTo', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRawMessage()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRawMessage');
        if (!$pluginInfo) {
            return parent::getRawMessage();
        } else {
            return $this->___callPlugins('getRawMessage', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setBodyHtml($html)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setBodyHtml');
        if (!$pluginInfo) {
            return parent::setBodyHtml($html);
        } else {
            return $this->___callPlugins('setBodyHtml', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setBodyText($text)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setBodyText');
        if (!$pluginInfo) {
            return parent::setBodyText($text);
        } else {
            return $this->___callPlugins('setBodyText', func_get_args(), $pluginInfo);
        }
    }
}
