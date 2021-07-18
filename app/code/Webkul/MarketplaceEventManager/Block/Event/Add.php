<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MarketplaceEventManager
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MarketplaceEventManager\Block\Event;

/*
 * Webkul Marketplace Product Create Block
 */
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\CategoryFactory;
use Magento\GoogleOptimizer\Model\Code as ModelCode;
use Webkul\Marketplace\Helper\Data as HelperData;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Add extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $_product;

    /**
     * @var \Magento\Catalog\Model\Category
     */
    protected $_category;

    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;

    /**
     * @var ModelCode
     */
    protected $_modelCode;

    /**
     * @var HelperData
     */
    protected $_helperData;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    protected $_option;
    
    protected $_value;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param Product                                $product
     * @param Category                               $category
     * @param ModelCode                              $modelCode
     * @param HelperData                             $helperData
     * @param ProductRepositoryInterface             $productRepository
     * @param array                                  $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        ProductFactory $product,
        CategoryFactory $category,
        ModelCode $modelCode,
        HelperData $helperData,
        ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Model\Product\Option $option,
        \Magento\Catalog\Model\Product\Option\Value $value,
        array $data = []
    ) {
        $this->_product = $product;
        $this->_category = $category;
        $this->_modelCode = $modelCode;
        $this->_helperData = $helperData;
        $this->_productRepository = $productRepository;
        $this->_option = $option;
        $this->_value = $value;

        parent::__construct($context, $data);
    }

    public function getProduct($id)
    {
        return $this->_product->create()->load($id);
    }

    public function getProductOptions($id)
    {
        return $this->_option->getProductOptionCollection($this->getProduct($id))->getData();
    }
    public function getValueCollectionOfOption($option)
    {
        return $this->_value->getValuesCollection($this->_option->load($option));
    }
    public function getCategory()
    {
        return $this->_category->create();
    }

    /**
     * Get Googleoptimizer Fields Values.
     *
     * @param ModelCode|null $experimentCodeModel
     *
     * @return array
     */
    public function getGoogleoptimizerFieldsValues()
    {
        $entityId = $this->getRequest()->getParam('id');
        $storeId = $this->_helperData->getCurrentStoreId();
        $experimentCodeModel = $this->_modelCode->loadByEntityIdAndType($entityId, 'product', $storeId);
        $result = [];
        $result['experiment_script'] =
        $experimentCodeModel ? $experimentCodeModel->getExperimentScript() : '';
        $result['code_id'] =
        $experimentCodeModel ? $experimentCodeModel->getCodeId() : '';

        return $result;
    }

    public function getProductBySku($sku)
    {
        return $this->_productRepository->get($sku);
    }
}
