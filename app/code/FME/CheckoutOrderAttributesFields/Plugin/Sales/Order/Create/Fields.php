<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Plugin\Sales\Order\Create;

/**
 * Sales Order Invoice PDF model
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Fields
{
    
    /**
     * @var \FME\CheckoutOrderAttributesFields\Helper\Data
     */
    private $helper;

    /**
     * @param \FME\CheckoutOrderAttributesFields\Helper\Data
     */
    public function __construct(
        \FME\CheckoutOrderAttributesFields\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }
    /**
     * after to Html plugin
     *
     * @param \Magento\Sales\Block\Adminhtml\Order\Create\Form\Account $subject
     * @param array $result
     */
    public function afterToHtml(
        \Magento\Sales\Block\Adminhtml\Order\Create\Form\Account $subject, $result
    ) {

        $orderAttributesForm = $subject->getLayout()->createBlock(
            'FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create\Fields'
        );
        $orderAttributesForm->setTemplate('FME_CheckoutOrderAttributesFields::sales/create/fields.phtml');
        $orderAttributesForm->setStore($subject->getStore()->getId());
        $orderAttributesFormHtml = $orderAttributesForm->toHtml();
        return $result . $orderAttributesFormHtml;
    }
}
