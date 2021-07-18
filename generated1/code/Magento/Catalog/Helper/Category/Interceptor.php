<?php
namespace Magento\Catalog\Helper\Category;

/**
 * Interceptor class for @see \Magento\Catalog\Helper\Category
 */
class Interceptor extends \Magento\Catalog\Helper\Category implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Helper\Context $context, \Magento\Catalog\Model\CategoryFactory $categoryFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Data\CollectionFactory $dataCollectionFactory, \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository)
    {
        $this->___init();
        parent::__construct($context, $categoryFactory, $storeManager, $dataCollectionFactory, $categoryRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStoreCategories');
        if (!$pluginInfo) {
            return parent::getStoreCategories($sorted, $asCollection, $toLoad);
        } else {
            return $this->___callPlugins('getStoreCategories', func_get_args(), $pluginInfo);
        }
    }
}
