<?php
namespace Webkul\MarketplaceEventManager\Controller\Rewrite\ValidateProduct;

/**
 * Interceptor class for @see \Webkul\MarketplaceEventManager\Controller\Rewrite\ValidateProduct
 */
class Interceptor extends \Webkul\MarketplaceEventManager\Controller\Rewrite\ValidateProduct implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder, \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter, \Magento\Catalog\Model\Product\Validator $productValidator, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Catalog\Model\ProductFactory $productFactory)
    {
        $this->___init();
        parent::__construct($context, $productBuilder, $dateFilter, $productValidator, $resultJsonFactory, $layoutFactory, $productFactory);
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
