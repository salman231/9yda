<?php
namespace Webkul\MarketplaceEventManager\Controller\Event\Sendremindermail;

/**
 * Interceptor class for @see \Webkul\MarketplaceEventManager\Controller\Event\Sendremindermail
 */
class Interceptor extends \Webkul\MarketplaceEventManager\Controller\Event\Sendremindermail implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\MarketplaceEventManager\Model\Sendmail $sendmail, \Magento\Customer\Model\Session $customerSession)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $sendmail, $customerSession);
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
