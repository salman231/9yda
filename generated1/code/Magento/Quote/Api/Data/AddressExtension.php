<?php
namespace Magento\Quote\Api\Data;

/**
 * Extension class for @see \Magento\Quote\Api\Data\AddressInterface
 */
class AddressExtension extends \Magento\Framework\Api\AbstractSimpleObject implements AddressExtensionInterface
{
    /**
     * @return \Magento\SalesRule\Api\Data\RuleDiscountInterface[]|null
     */
    public function getDiscounts()
    {
        return $this->_get('discounts');
    }

    /**
     * @param \Magento\SalesRule\Api\Data\RuleDiscountInterface[] $discounts
     * @return $this
     */
    public function setDiscounts($discounts)
    {
        $this->setData('discounts', $discounts);
        return $this;
    }

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

    /**
     * @return \Magento\Framework\Api\AttributeInterface[]|null
     */
    public function getCheckoutFields()
    {
        return $this->_get('checkout_fields');
    }

    /**
     * @param \Magento\Framework\Api\AttributeInterface[] $checkoutFields
     * @return $this
     */
    public function setCheckoutFields($checkoutFields)
    {
        $this->setData('checkout_fields', $checkoutFields);
        return $this;
    }
}
