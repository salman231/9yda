<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Product\Deny;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Product\Deny
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Product\Deny implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\Stdlib\DateTime $dateTime, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor, \Webkul\Marketplace\Model\ProductFactory $productModel, \Magento\Catalog\Model\Product\Action $productAction, \Webkul\Marketplace\Helper\Data $mpHelper, \Webkul\Marketplace\Helper\Notification $notificationHelper, \Magento\Catalog\Model\CategoryFactory $categoryFactory, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Customer\Model\CustomerFactory $customerModel, \Webkul\Marketplace\Helper\Email $mpEmailHelper)
    {
        $this->___init();
        parent::__construct($context, $filter, $date, $dateTime, $storeManager, $productRepository, $productPriceIndexerProcessor, $productModel, $productAction, $mpHelper, $notificationHelper, $categoryFactory, $productFactory, $customerModel, $mpEmailHelper);
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
