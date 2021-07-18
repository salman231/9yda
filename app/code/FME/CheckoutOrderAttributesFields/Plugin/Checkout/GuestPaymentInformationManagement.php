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

class GuestPaymentInformationManagement
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
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \FME\CheckoutOrderAttributesFields\Helper\Data $helper
     * @codeCoverageIgnore
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
    public function beforeSavePaymentInformationAndPlaceOrder(
        \Magento\Checkout\Model\GuestPaymentInformationManagement $subject,
        $cartId,
        $email,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    ) {
         // print_r("here");exit;
        if (!$billingAddress) {
            return;
        }
        $this->saveAdditionalFields($billingAddress, $cartId);
    }
    /**
     * @inheritdoc
     */
    public function beforeSavePaymentInformation(
        \Magento\Checkout\Model\GuestPaymentInformationManagement $subject,
        $cartId,
        $email,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    ) {
        if (!$billingAddress) {
            return;
        }
        $this->saveAdditionalFields($billingAddress, $cartId);
    }
    /**
     * @param \Magento\Quote\Api\Data\AddressInterface $billingAddress
     * @param int $cartId
     * @return void
     */
    protected function saveAdditionalFields(\Magento\Quote\Api\Data\AddressInterface $billingAddress, $cartId)
    {
        $coafFields = [];
        if ($billingAddress->getExtensionAttributes() != null && $billingAddress->getExtensionAttributes()->getCoaf() != null) {
            foreach ($billingAddress->getExtensionAttributes()->getCoaf() as $extensionAttributes) {
                $coafFields[$extensionAttributes->getAttributeCode()] = [ 'value'=> $extensionAttributes->getValue()];
            }
        }

        $this->helper->setCoafFields($coafFields);
        $quoteId = $this->checkoutSession->getQuote()->getId();
        $quote = $this->quoteRepository->getActive($quoteId);
        $quote->setCoaf(json_encode($this->helper->getCoafFields()));
    }
}
