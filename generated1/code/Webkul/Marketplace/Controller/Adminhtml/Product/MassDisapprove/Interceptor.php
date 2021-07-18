<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Product\MassDisapprove;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Product\MassDisapprove
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Product\MassDisapprove implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Store\Model\StoreManagerInterface $storeManager, \Webkul\Marketplace\Model\ResourceModel\Product\CollectionFactory $collectionFactory, \Magento\Catalog\Model\Indexer\Product\Price\Processor $productPriceIndexerProcessor, \Webkul\Marketplace\Model\ProductFactory $mpProductFactory, \Magento\Catalog\Model\Product\Action $productAction, \Magento\Catalog\Model\Indexer\Product\Eav\Processor $eavProcessor, \Magento\Customer\Model\CustomerFactory $customerFactory, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Catalog\Model\CategoryFactory $categoryFactory, \Webkul\Marketplace\Helper\Data $mpHelper, \Webkul\Marketplace\Helper\Email $mpEmailHelper, \Webkul\Marketplace\Helper\Notification $mpNotificationHelper)
    {
        $this->___init();
        parent::__construct($context, $filter, $storeManager, $collectionFactory, $productPriceIndexerProcessor, $mpProductFactory, $productAction, $eavProcessor, $customerFactory, $productFactory, $categoryFactory, $mpHelper, $mpEmailHelper, $mpNotificationHelper);
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
