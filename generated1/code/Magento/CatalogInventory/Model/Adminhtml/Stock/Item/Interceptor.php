<?php
namespace Magento\CatalogInventory\Model\Adminhtml\Stock\Item;

/**
 * Interceptor class for @see \Magento\CatalogInventory\Model\Adminhtml\Stock\Item
 */
class Interceptor extends \Magento\CatalogInventory\Model\Adminhtml\Stock\Item implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Customer\Model\Session $customerSession, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration, \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry, \Magento\CatalogInventory\Api\StockItemRepositoryInterface $stockItemRepository, \Magento\Customer\Api\GroupManagementInterface $groupManagement, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $customerSession, $storeManager, $stockConfiguration, $stockRegistry, $stockItemRepository, $groupManagement, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getQty()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getQty');
        if (!$pluginInfo) {
            return parent::getQty();
        } else {
            return $this->___callPlugins('getQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMinQty()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMinQty');
        if (!$pluginInfo) {
            return parent::getMinQty();
        } else {
            return $this->___callPlugins('getMinQty', func_get_args(), $pluginInfo);
        }
    }
}
