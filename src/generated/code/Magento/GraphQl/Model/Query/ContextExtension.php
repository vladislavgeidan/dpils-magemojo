<?php
namespace Magento\GraphQl\Model\Query;

/**
 * Extension class for @see \Magento\GraphQl\Model\Query\ContextInterface
 */
class ContextExtension extends \Magento\Framework\Api\AbstractSimpleObject implements ContextExtensionInterface
{
    /**
     * @return \Magento\Store\Api\Data\StoreInterface|null
     */
    public function getStore()
    {
        return $this->_get('store');
    }

    /**
     * @param \Magento\Store\Api\Data\StoreInterface $store
     * @return $this
     */
    public function setStore(\Magento\Store\Api\Data\StoreInterface $store)
    {
        $this->setData('store', $store);
        return $this;
    }

    /**
     * @return boolean|null
     */
    public function getIsCustomer()
    {
        return $this->_get('is_customer');
    }

    /**
     * @param boolean $isCustomer
     * @return $this
     */
    public function setIsCustomer($isCustomer)
    {
        $this->setData('is_customer', $isCustomer);
        return $this;
    }
}
