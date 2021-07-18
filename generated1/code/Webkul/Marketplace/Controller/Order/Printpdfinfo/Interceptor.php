<?php
namespace Webkul\Marketplace\Controller\Order\Printpdfinfo;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Order\Printpdfinfo
 */
class Interceptor extends \Webkul\Marketplace\Controller\Order\Printpdfinfo implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Customer\Model\Url $customerUrl, \Webkul\Marketplace\Helper\Data $helper, \Webkul\Marketplace\Model\SellerFactory $mpSellerModel)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $formKeyValidator, $customerUrl, $helper, $mpSellerModel);
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
