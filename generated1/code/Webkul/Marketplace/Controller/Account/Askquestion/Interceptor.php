<?php
namespace Webkul\Marketplace\Controller\Account\Askquestion;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Account\Askquestion
 */
class Interceptor extends \Webkul\Marketplace\Controller\Account\Askquestion implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Webkul\Marketplace\Helper\Data $marketplaceHelper, \Webkul\Marketplace\Helper\Email $mpEmailHelper, \Magento\Framework\Json\Helper\Data $jsonHelper)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $marketplaceHelper, $mpEmailHelper, $jsonHelper);
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
