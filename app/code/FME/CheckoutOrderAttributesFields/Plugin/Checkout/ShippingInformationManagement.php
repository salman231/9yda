<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Plugin\Checkout;

class ShippingInformationManagement
{
    private $quoteRepository;
    /**
     * @var \FME\CheckoutOrderAttributesFields\Helper\Data
     */
    private $helper;
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;
    /**
     * Constructor initialization
     *
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \FME\CheckoutOrderAttributesFields\Helper\Data $helper
     * @return void
     */
    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        \FME\CheckoutOrderAttributesFields\Helper\Data $helper
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->checkoutSession = $checkoutSession;
        $this->helper          = $helper;
    }

    /**
     * @inheritdoc
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        
        $shippingAddress = $addressInformation->getShippingAddress();
        $billingAddress = $addressInformation->getBillingAddress();
        $extAttributes = $shippingAddress->getExtensionAttributes();
        $coafFields = [];
        if ($billingAddress->getExtensionAttributes() != null &&
           $billingAddress->getExtensionAttributes()->getCoaf() != null
        ) {
            foreach ($billingAddress->getExtensionAttributes()->getCoaf() as $extensionAttributes) {
                $coafFields[$extensionAttributes->getAttributeCode()] = [ 'value'=> $extensionAttributes->getValue()];
            }
        }
        if ($shippingAddress->getExtensionAttributes() != null &&
            $shippingAddress->getExtensionAttributes()->getCoaf() != null
        ) {
            foreach ($shippingAddress->getExtensionAttributes()->getCoaf() as $extensionAttributes) {
                $coafFields[$extensionAttributes->getAttributeCode()] = [ 'value'=> $extensionAttributes->getValue()];
            }
        }
        $this->helper->setCoafFields($coafFields);
        $quote = $this->quoteRepository->getActive($cartId);
        $quote->setCoaf(json_encode($this->helper->getCoafFields()));
    }
}
