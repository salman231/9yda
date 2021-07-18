<?php

/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */

namespace FME\CheckoutOrderAttributesFields\Block\Adminhtml\Attribute\Edit\Tab;

class AssignProducts extends \Magento\Backend\Block\Template
{
  /**
   * Block template
   *
   * @var string
   */
  protected $_template = 'attribute/assign_products.phtml';

  /**
   * @var \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
   */
  protected $blockGrid;

  /**
   * @var \Magento\Framework\Registry
   */
  protected $registry;

  /**
   * AssignProducts constructor.
   *
   * @param \Magento\Backend\Block\Template\Context $context
   * @param \Magento\Framework\Registry $registry
   * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
   * @param array $data
   */
  public function __construct(
    \Magento\Backend\Block\Template\Context $context,
    \Magento\Framework\Registry $registry,
    array $data = []
  ) {
    $this->registry = $registry;
    parent::__construct($context, $data);
  }

  /**
   * Retrieve instance of grid block
   *
   * @return \Magento\Framework\View\Element\BlockInterface
   * @throws \Magento\Framework\Exception\LocalizedException
   */
  public function getBlockGrid()
  {
    if (null === $this->blockGrid) {
      $this->blockGrid = $this->getLayout()->createBlock(
        'FME\CheckoutOrderAttributesFields\Block\Adminhtml\Attribute\Edit\Tab\Product',
        'category.product.grid'
      );
    }
    return $this->blockGrid;
  }

  /**
   * Return HTML of grid block
   *
   * @return string
   */
  public function getGridHtml()
  {
    return $this->getBlockGrid()->toHtml();
  }

  /**
   * @return string|null
   */
  public function getProductsJson()
  {
    if(!empty($this->getAttribute()->getProductId()))
    {
      return $this->getAttribute()->getCategoryProducts();
    }
    return '{}';
  }
  
  /**
   * @return object
   */
  public function getAttribute()
  {
    return $this->registry->registry('entity_attribute');
  }
}
