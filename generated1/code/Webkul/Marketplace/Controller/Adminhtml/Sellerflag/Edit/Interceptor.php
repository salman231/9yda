<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Sellerflag\Edit;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Sellerflag\Edit
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Sellerflag\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\Marketplace\Api\Data\SellerFlagReasonInterfaceFactory $sellerFlagFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $sellerFlagFactory);
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
