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
class AddHtmlToOrderShippingViewObserver implements ObserverInterface
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
        if($observer->getElementName() == 'order_info') {
            $orderShippingViewBlock = $observer->getLayout()->getBlock($observer->getElementName());
            //$order = $orderShippingViewBlock->getOrder();
            $coafBlock = $observer->getLayout()->getBlock('coaf.fields');
            if($coafBlock){
                $html = $observer->getTransport()->getOutput() . $coafBlock->toHtml();
                $observer->getTransport()->setOutput($html);
            }
        }
    }
}
