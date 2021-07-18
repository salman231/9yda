<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Model;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Attribute model
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Attribute extends \Magento\Framework\Model\AbstractExtensibleModel
{

    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY = 'checkoutorderattributesfields';

    /**
     * Product cache tag
     */
    const CACHE_TAG = 'checkoutorderattributesfields';

    /**
     * Category product relation cache tag
     */
    const CACHE_PRODUCT_CATEGORY_TAG = 'checkoutorderattributesfields_attribute';

    /**
     * Product Store Id
     */
    const STORE_ID = 'store_id';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'checkoutorderattributesfields';

    /**
     * @var string
     */
    protected $_eventObject = 'attribute';

    /**
     * @var string
     */
    private $resource;
    /**
     * Product constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param AttributeValueFactory $customAttributeFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        AttributeValueFactory $customAttributeFactory,
        \FME\CheckoutOrderAttributesFields\Model\ResourceModel\Attribute $resource,
        \FME\CheckoutOrderAttributesFields\Model\ResourceModel\Attribute\Collection $resourceCollection,
        array $data = []
    ) {
        $this->resource = $resource;
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magento\Catalog\Model\ResourceModel\Product');
    }

    /**
     * Retrieve Store Id
     *
     * @return int
     */
    public function getStoreId()
    {
        if ($this->hasData(self::STORE_ID)) {
            return $this->getData(self::STORE_ID);
        }
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * Retrieve Option Value by Id
     *
     * @return int
     */
    public function getOptionValueById($id, $storeId = null)
    {
        if ($storeId == null) {
            $storeId = $this->_storeManager->getStore()->getId();
        }
        return $this->resource->getOptionValueById($id, $storeId);
    }
    /**
     * Get collection instance
     *
     * @return object
     */
    public function getResourceCollection()
    {
        $collection = parent::getResourceCollection();
        $collection->setStoreId($this->getStoreId());
        return $collection;
    }

    /**
     * Identifier getter
     *
     * @return int
     */
    public function getId()
    {
        return $this->_getData('attribute_id');
    }

    /**
     * Set entity Id
     *
     * @param int $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setData('attribute_id', $value);
    }
}
