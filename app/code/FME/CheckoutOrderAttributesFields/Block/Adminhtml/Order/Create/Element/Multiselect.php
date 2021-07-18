<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create\Element;

class Multiselect extends \FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create\Element\Select
{
    /**
     * Return array of select options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->getCurrentAttribute()->getSource()->getAllOptions(false);
    }

    /**
     * Return array of values
     *
     * @return array
     */
    public function getValues()
    {
        $value = $this->getValue();
        return explode(',', $value);
    }

    /**
     * Check is value selected
     *
     * @param string $value
     * @return boolean
     */
    public function isSelected($value)
    {
        return in_array($value, $this->getValues());
    }
}
