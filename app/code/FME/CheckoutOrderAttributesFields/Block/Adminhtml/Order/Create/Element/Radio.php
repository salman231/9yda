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

class Radio extends \FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create\Element\AbstractRenderer
{
    /**
     * Return array of select options
     *
     * @return array
     */
    public function getOptions()
    {
    	$empty = $this->isRequired();
        return $this->getCurrentAttribute()->getSource()->getAllOptions(!$empty);
    }
}
