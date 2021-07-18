<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Model\Source;

class CountryOption implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $methods[] = [
            'label' => __('No'),
            'value' => 0
        ];
        $methods[] = [
            'label' => __('Billing Country'),
            'value' => 1
        ];
        $methods[] = [
            'label' => __('Shipping Country'),
            'value' => 2
        ];
        return $methods;
    }
    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $methods = [
            '0' => __('No'),
            '1' => __('Billing Country'),
            '2' => __('Shipping Country')
        ];
        return $methods;
    }//end toArray()
}//end class
