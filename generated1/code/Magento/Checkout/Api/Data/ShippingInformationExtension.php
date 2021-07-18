<?php
namespace Magento\Checkout\Api\Data;

/**
 * Extension class for @see \Magento\Checkout\Api\Data\ShippingInformationInterface
 */
class ShippingInformationExtension extends \Magento\Framework\Api\AbstractSimpleObject implements ShippingInformationExtensionInterface
{
    /**
     * @return \Magento\Framework\Api\AttributeInterface[]|null
     */
    public function getCoaf()
    {
        return $this->_get('coaf');
    }

    /**
     * @param \Magento\Framework\Api\AttributeInterface[] $coaf
     * @return $this
     */
    public function setCoaf($coaf)
    {
        $this->setData('coaf', $coaf);
        return $this;
    }
}
