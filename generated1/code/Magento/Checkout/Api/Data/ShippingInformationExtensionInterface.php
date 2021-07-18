<?php
namespace Magento\Checkout\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Checkout\Api\Data\ShippingInformationInterface
 */
interface ShippingInformationExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return \Magento\Framework\Api\AttributeInterface[]|null
     */
    public function getCoaf();

    /**
     * @param \Magento\Framework\Api\AttributeInterface[] $coaf
     * @return $this
     */
    public function setCoaf($coaf);
}
