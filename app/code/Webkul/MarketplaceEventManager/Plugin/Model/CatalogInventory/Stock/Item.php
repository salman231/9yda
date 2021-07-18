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
namespace Webkul\MarketplaceEventManager\Plugin\Model\CatalogInventory\Stock;

class Item
{
    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $_product;

    /**
     * @var \Webkul\MarketplaceEventManager\Helper\Data
     */
    protected $_datahelper;

    /**
     * @param \Magento\Catalog\Model\Product $product
     */
    public function __construct(
        \Magento\Catalog\Model\ProductFactory $product,
        \Webkul\MarketplaceEventManager\Helper\Data $datahelper
    ) {
        $this->_product = $product;
        $this->_datahelper = $datahelper;
    }

    public function afterGetQty(\Magento\CatalogInventory\Model\Stock\Item $subject, $result)
    {
        $qty = $this->_datahelper->getCalculatedQty($subject->getProductId());
        if ($qty) {
            return $qty;
        } else {
            return $result;
        }
    }
}
