<?php
namespace Webkul\Marketplace\Controller\Transaction\View;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Transaction\View
 */
class Interceptor extends \Webkul\Marketplace\Controller\Transaction\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Customer\Model\Session $customerSession, \Webkul\Marketplace\Model\Sellertransaction $sellertransaction, \Webkul\Marketplace\Helper\Data $helper, \Webkul\Marketplace\Helper\Notification $notificationHelper, \Magento\Customer\Model\Url $customerUrl)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $customerSession, $sellertransaction, $helper, $notificationHelper, $customerUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
