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
class SaveFields
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
     * before Create order
     *
     * @param object
     * @return void
     */
    public function beforeCreateOrder(
        \Magento\Sales\Model\AdminOrder\Create $subject
    ) {
        $data = $subject->getData('fme');
        $saved = $this->helper->getCoreCoafFieldsMainDetails();
        foreach ($data as $key => $value) {
            if (in_array($saved, ['checkbox','multiselect'])) {
                $saved[$key]['value_id'] = is_array($value)?implode(",", $value):$value;
                $value = $this->helper->getOptionLabels($value, $saved[$key]['store'], true);
            } elseif (in_array($saved, ['radio','select'])) {
                $saved[$key]['value_id'] = is_array($value)?implode(",", $value):$value;
                $value = $this->helper->getOptionLabels($value, $saved[$key]['store'], false);
            } else if ($saved[$key]['type'] == 'boolean') {
                $saved[$key]['value_id'] = $value;
                $value = $value == 1?__('Yes'):__("No");
            }
            $saved[$key]['value'] = $value;
        }
        $this->helper->setAdminCoaf(json_encode($saved));
    }
}
