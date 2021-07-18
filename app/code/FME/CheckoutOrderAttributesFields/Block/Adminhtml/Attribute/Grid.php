<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Block\Adminhtml\Attribute;

use Magento\Eav\Block\Adminhtml\Attribute\Grid\AbstractGrid;

/**
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Grid extends AbstractGrid
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \FME\CheckoutOrderAttributesFields\Model\ResourceModel\Attribute\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_module = 'checkoutorderattributesfields';
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Prepare product attributes grid collection object
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare product attributes grid columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {

        $this->addColumn(
            'attribute_code',
            [
                'header' => __('Code'),
                'sortable' => true,
                'index' => 'attribute_code',
                'type' => 'text',
                'align' => 'left'
            ]
        );
        $this->addColumnAfter(
            'frontend_label',
            [
                'header' => __('Default Label'),
                'sortable' => true,
                'index' => 'frontend_label',
                'type' => 'text',
                'align' => 'left'
            ],
            'attribute_code'
        );

        $this->addColumnAfter(
            'is_visible',
            [
                'header' => __('Enabled'),
                'sortable' => true,
                'index' => 'is_visible_on_front',
                'type' => 'options',
                'options' => ['1' => __('Yes'), '0' => __('No')],
                'align' => 'center'
            ],
            'frontend_label'
        );

        $this->addColumnAfter(
            'is_required',
            [
                'header' => __('Required'),
                'sortable' => true,
                'index' => 'is_required',
                'type' => 'options',
                'options' => ['1' => __('Yes'), '0' => __('No')],
                'align' => 'center'
            ],
            'is_visible_on_front'
        );

        $this->addColumnAfter(
            'is_global',
            [
                'header' => __('Checkout Step'),
                'sortable' => true,
                'index' => 'is_global',
                'type' => 'options',
                'options' => [
                    1 => __('Billing Address'),
                    2 => __('Shipping Address'),
                    3 => __('Shipping Method'),
                    4 => __('Payment/Review Step'),
                ],
                'align' => 'center'
            ],
            'is_visible'
        );

        $this->addColumn(
            'position',
            [
                'header' => __('Position'),
                'sortable' => true,
                'index' => 'position',
                'type' => 'text',
                'align' => 'center'
            ],
            'is_global'
        );

        $this->addColumnAfter(
            'fme_email',
            [
                'header' => __('Email'),
                'sortable' => true,
                'index' => 'fme_email',
                'type' => 'options',
                'options' => ['1' => __('Yes'), '0' => __('No')],
                'align' => 'center'
            ],
            'position'
        );
        $this->addColumnAfter(
            'fme_pdf',
            [
                'header' => __('PDF'),
                'sortable' => true,
                'index' => 'fme_pdf',
                'type' => 'options',
                'options' => ['1' => __('Yes'), '0' => __('No')],
                'align' => 'center'
            ],
            'show_email'
        );

        return $this;
    }
}
