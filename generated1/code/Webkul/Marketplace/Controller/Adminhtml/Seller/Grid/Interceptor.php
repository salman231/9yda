<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Seller\Grid;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Seller\Grid
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Seller\Grid implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\Marketplace\Model\SellerFactory $sellerModel)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $sellerModel);
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
