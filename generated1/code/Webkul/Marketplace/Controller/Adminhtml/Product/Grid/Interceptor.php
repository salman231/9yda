<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Product\Grid;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Product\Grid
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Product\Grid implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\Marketplace\Model\ProductFactory $productModel)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $productModel);
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
