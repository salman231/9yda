<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Productflag\Edit;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Productflag\Edit
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Productflag\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\Marketplace\Api\Data\ProductFlagReasonInterfaceFactory $productFlagFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $productFlagFactory);
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
