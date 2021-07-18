<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Plugin\Sales;

/**
 * Sales Order Shipment PDF model
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Shipment extends \Magento\Sales\Model\Order\Pdf\Shipment
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
     * Return PDF document
     *
     * @param \Magento\Sales\Model\Order\Shipment[] $shipments
     * @return \Zend_Pdf
     */
    public function aroundGetPdf(
        \Magento\Sales\Model\Order\Pdf\Shipment $subject,
        callable $proceed,
        $shipments = []
    ) {
        $subject->_beforeGetPdf();
        $subject->_initRenderer('shipment');

        $pdf = new \Zend_Pdf();
        $subject->_setPdf($pdf);
        $style = new \Zend_Pdf_Style();
        $subject->_setFontBold($style, 10);
        foreach ($shipments as $shipment) {
            if ($shipment->getStoreId()) {
                $subject->_localeResolver->emulate($shipment->getStoreId());
                $subject->_storeManager->setCurrentStore($shipment->getStoreId());
            }
            $page = $subject->newPage();
            $order = $shipment->getOrder();
            /* Add image */
            $subject->insertLogo($page, $shipment->getStore());
            /* Add address */
            $subject->insertAddress($page, $shipment->getStore());
            /* Add head */
            $subject->insertOrder(
                $page,
                $shipment,
                $subject->_scopeConfig->isSetFlag(
                    self::XML_PATH_SALES_PDF_SHIPMENT_PUT_ORDER_ID,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                    $order->getStoreId()
                )
            );
            ///// Insert FME Fields ///////
            $this->getCoafFields($order, $page, $subject);
            ///// End Insert FME Fields ///////
            /* Add document text and number */
            $subject->insertDocumentNumber($page, __('Packing Slip # ') . $shipment->getIncrementId());
            /* Add table */
            $subject->_drawHeader($page);
            /* Add body */
            foreach ($shipment->getAllItems() as $item) {
                if ($item->getOrderItem()->getParentItem()) {
                    continue;
                }
                /* Draw item */
                $subject->_drawItem($item, $page, $order);
                $page = end($pdf->pages);
            }
        }
        $subject->_afterGetPdf();
        if ($shipment->getStoreId()) {
            $subject->_localeResolver->revert();
        }
        return $pdf;
    }
    /**
     * Add custom FME Fields to Pdf
     *
     * @param  object $order
     * @param  object $page
     * @param  object $subject
     * @return \Zend_Pdf_Page
     */
    public function getCoafFields($order, &$page, $subject)
    {
        $coaf = $order->getCoaf();
        $coafFields = json_decode($coaf);
        $hasPdf = false;
        
        if ($this->helper->getStatus() && $coaf != '' && !empty((array)$coafFields)) {
            foreach ($coafFields as $field) {
                if ($field->pdf == 1) {
                    $hasPdf = true;
                    break;
                }
            }
            if ($hasPdf == false) {
                return;
            }
            $page->setFillColor(new \Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
            $page->setLineWidth(0.5);
            $page->drawRectangle(25, $subject->y, 570, $subject->y-25);
            $subject->y -=15;
            $subject->_setFontBold($page, 12);
            $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
            $page->drawText($this->helper->getHeading(), 35, $subject->y, 'UTF-8');

            $subject->y -=10;
            $page->setFillColor(new \Zend_Pdf_Color_GrayScale(1));

            $subject->_setFontRegular($page);
            $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
            $this->addFieldsToPage($subject, $page, $coafFields);
        }
    }
    /**
     * Add custom FME Fields to Pdf Page
     *
     * @param  object $subject
     * @param  object $page
     * @param  array $coafFields
     * @return \Zend_Pdf_Page
     */
    public function addFieldsToPage($subject, &$page, $coafFields)
    {
        $paymentLeft = 35;
        $yPayments   = $subject->y - 15;
        $i=0;
        $temp = $yPayments;
        $temp2 = $temp;
        foreach ($coafFields as $field) {
            if ($field->pdf != 1 || !isset($field->value)) {
                continue;
            }
            $value = is_array($field->value)? implode(", ", $field->value):$field->value;
            if (trim($value) != '') {
                $i++;
                if ($i%2 == 0) {
                    $paymentLeft = 285;
                    $temp2 = $temp;
                    $temp = $yPayments;
                } else {
                    $temp = $yPayments;
                    $paymentLeft = 35;
                }
                $subject->_setFontBold($page, 9);
                $page->drawText($field->label . " : ", $paymentLeft, $temp, 'UTF-8');
                $temp -= 10;
                $subject->_setFontRegular($page, 8);
                foreach ($subject->string->split($value, 65, true, true) as $_value) {
                    if ($temp <= 20) {
                        $yPayments = $temp2 < $temp ? $temp2: $temp;
                        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
                        $subject->_setFontRegular($page, 5);
                        $page->setLineWidth(0.5);
                        $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.5));
                        $page->drawLine(25, $subject->y, 25, $yPayments);
                        $page->drawLine(25, $yPayments, 570, $yPayments);
                        $page->drawLine(570, $subject->y, 570, $yPayments);
                        $page = $subject->newPage();
                        $page->setFillColor(new \Zend_Pdf_Color_Rgb(0.93, 0.92, 0.92));
                        $page->setLineWidth(0.5);
                        $page->drawRectangle(25, $subject->y, 570, $subject->y-25);
                        $subject->y -=15;
                        $subject->_setFontBold($page, 12);
                        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
                        $page->drawText($this->helper->getheading(), 35, $subject->y, 'UTF-8');
                        $subject->y -=10;
                        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(1));
                        $subject->_setFontRegular($page, 8);
                        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
                        $paymentLeft = 35;
                        $yPayments   = $subject->y - 15;
                        $i=0;
                        $temp = $yPayments;
                        $temp2 = $temp;
                    }
                    $page->drawText(strip_tags(trim($_value)), $paymentLeft, $temp, 'UTF-8');
                    $temp -= 15;
                }
                if ($i%2 == 0) {
                    $yPayments =$temp2 < $temp?$temp2:$temp;
                }
            }
        }
        $yPayments -= 20;
        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
        $subject->_setFontRegular($page, 5);
        $page->setLineWidth(0.5);
        $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.5));
        $page->drawLine(25, $subject->y, 25, $yPayments);
        $page->drawLine(25, $yPayments, 570, $yPayments);
        $page->drawLine(570, $subject->y, 570, $yPayments);
        $page->setLineWidth(0);
        $subject->y = $yPayments - 15;
    }
}
