<?php
/**
 * 
 */
namespace FME\CheckoutOrderAttributesFields\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Save checkout fields with quote shipping address.
 *
 */
class SaveCheckoutFieldsToOrderObserver implements ObserverInterface
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
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfiguration
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
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $quote = $observer->getQuote();
        /** @var \Magento\Quote\Model\Quote $quote */
        //$quote = $this->quoteRepositor->get($order->getQuoteId());
        if (!empty($this->helper->getAdminCoaf())) {
            $quote->setCoaf($this->helper->getAdminCoaf());
            $this->helper->setAdminCoaf('');
        }
        $order->setCoaf($quote->getCoaf());
        return $this;
    }
}
