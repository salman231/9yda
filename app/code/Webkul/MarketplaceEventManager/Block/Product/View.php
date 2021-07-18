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
namespace Webkul\MarketplaceEventManager\Block\Product;

class View extends \Magento\Framework\View\Element\Template
{
    protected $_product;
    protected $_option;
    protected $_value;
    
    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param Product                                $product
     * @param array                                  $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ProductFactory $product,
        \Magento\Catalog\Model\Product\Option $option,
        \Magento\Catalog\Model\Product\Option\Value $value,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        array $data = []
    ) {
        $this->_product = $product;
        $this->_option = $option;
        $this->_value = $value;
        $this->_date = $date;
        parent::__construct($context, $data);
    }
    public function getProduct()
    {
        if ($this->getRequest()->getFullActionName() == 'wishlist_index_configure') {
            $id = $this->getRequest()->getParam('product_id');
        } else {
            $id = $this->getRequest()->getParam('id');
        }
        return $this->_product->create()->load($id);
    }
    public function getProductOptions($product)
    {
        return $this->_option->getProductOptionCollection($product)->getData();
    }
    public function getValueCollectionOfOption($option)
    {
        return $this->_value->getValuesCollection($this->_option->load($option));
    }
    public function getEventExpiredStatus()
    {
        $product = $this->getProduct();
        $currenttime = strtotime($this->_date->gmtDate('Y-m-d G:i:s'));
        $eventendTime = strtotime($product->getEventEndDate());
        if ($currenttime > $eventendTime) {
            return true;
        }
        return false;
    }
}
