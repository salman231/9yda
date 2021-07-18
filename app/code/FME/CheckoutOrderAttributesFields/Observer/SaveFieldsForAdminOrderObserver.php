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
class SaveFieldsForAdminOrderObserver implements ObserverInterface
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
        \FME\CheckoutOrderAttributesFields\Helper\Data $helper
    ) {
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
        $quote->setCoaf($this->helper->getAdminCoaf());
        $order->setCoaf($this->helper->getAdminCoaf());
        return $this;
    }
}
