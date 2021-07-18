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
use Magento\Framework\Filesystem;

/**
 * Attribute model
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CustomerValues extends \Magento\Framework\Model\AbstractModel
{

    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY = 'fme_checkoutorderattributesfields';

    /**
     * Product cache tag
     */
    const CACHE_TAG = 'fme_checkoutorderattributesfields';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'fme_checkoutorderattributesfields';

    /**
     * @var string
     */
    protected $_eventObject = 'checkoutorderattributesfields';

    /**
     * @var string
     */
    private $resource;

    /**
     * Entity factory1
     *
     * @var \Magento\Eav\Model\EntityFactory
     */
    private $eavEntityFactory;
    /**
     * File Uploader factory.
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    private $fileUploaderFactory;
 
    private $mediaDirectory;

    /**
     * Product constructor.
     * @param \FME\CheckoutOrderAttributesFields\Model\ResourceModel\Attribute $resource
     * @param \Magento\Eav\Model\EntityFactory $eavEntityFactory
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        \FME\CheckoutOrderAttributesFields\Model\ResourceModel\CustomerValues $resource,
        \Magento\Eav\Model\EntityFactory $eavEntityFactory,
        Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        $this->resource = $resource;
        $this->eavEntityFactory = $eavEntityFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->fileUploaderFactory = $fileUploaderFactory;
    }

    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('FME\CheckoutOrderAttributesFields\Model\ResourceModel\CustomerValues');
    }

    /**
     * Retrieve Option Value by Id
     *
     * @return int
     */
    public function saveOrderValues($data, $order_id, $entityTypeId = null)
    {
        if ($entityTypeId == null || $entityTypeId < 1) {
            $entityTypeId = (int)$this->eavEntityFactory->create()->setType(
                \FME\CheckoutOrderAttributesFields\Model\Attribute::ENTITY
            )->getTypeId();
        }
        foreach ($data as $key => $value) {
            if (stripos($key, 'fme_') !== false) {
                $attribute_code = str_replace('fme_', '', $key);
                $value = is_array($value)?implode(",", $value):$value;
                $this->saveCustomerValue($attribute_code, $value, $order_id, $entityTypeId);
            }
        }
        return;
    }

    /**
     * Save Option Value by Id
     *
     * @return int
     */
    public function saveAllAdminOrderValue($data, $order_id, $store_id, $coafDetails)
    {
        $entityTypeId = (int)$this->eavEntityFactory->create()->setType(
            \FME\CheckoutOrderAttributesFields\Model\Attribute::ENTITY
        )->getTypeId();
        return $this->resource->saveAdminOrderValue($data, $order_id, $store_id, $coafDetails, $entityTypeId);
    }


    /**
     * Retrieve Option Value by Id
     *
     * @return int
     */
    public function saveOrderValue($code, $value, $order_id, $entityTypeId = null)
    {
        if ($entityTypeId == null || $entityTypeId < 1) {
            $entityTypeId = (int)$this->eavEntityFactory->create()->setType(
                \FME\CheckoutOrderAttributesFields\Model\Attribute::ENTITY
            )->getTypeId();
        }
        return $this->resource->saveOrderValue($code, $value, $order_id, $entityTypeId);
    }
    /**
     * Retrieve attribute Id and label
     *
     * @return int
     */
    public function getDependableAttributes()
    {
        
        $entityTypeId = (int)$this->eavEntityFactory->create()->setType(
            \FME\CheckoutOrderAttributesFields\Model\Attribute::ENTITY
        )->getTypeId();
        
        return $this->resource->getDependableAttributes($entityTypeId);
    }
    /**
     * Retrieve Option Value by Id
     *
     * @return int
     */
    public function getOptionValueById($id, $storeId, $needArray = false)
    {
        return $this->resource->getOptionValueById($id, $storeId, $needArray);
    }
    /**
     * Identifier getter
     *
     * @return int
     */
    public function getId()
    {
        return $this->_getData('entity_id');
    }

    /**
     * Set entity Id
     *
     * @param int $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setData('entity_id', $value);
    }
}
