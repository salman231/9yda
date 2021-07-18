<?php
/*
    ////////////////////////////////////////////////////////////////////////////////
    \\\\\\\\\\\\\\\\\\\\\\\\\  FME Photogallery Module  \\\\\\\\\\\\\\\\\\\\\\\\\
    /////////////////////////////////////////////////////////////////////////////////
    \\\\\\\\\\\\\\\\\\\\\\\\\ NOTICE OF LICENSE\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    ///////                                                                   ///////
    \\\\\\\ This source file is subject to the Open Software License (OSL 3.0)\\\\\\\
    ///////   that is bundled with this package in the file LICENSE.txt.      ///////
    \\\\\\\   It is also available through the world-wide-web at this URL:    \\\\\\\
    ///////          http://opensource.org/licenses/osl-3.0.php               ///////
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    ///////                      * @category   FME                            ///////
    \\\\\\\                      * @package    FME_Productattachments              \\\\\\\
    ///////    * @author    FME Extensions <support@fmeextensions.com>   ///////
    \\\\\\\                                                                   \\\\\\\
    /////////////////////////////////////////////////////////////////////////////////
    \\* @copyright  Copyright 2015 © fmeextensions.com All right reserved\\\
    /////////////////////////////////////////////////////////////////////////////////
 */

namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute;

class Gridp extends \Magento\Catalog\Controller\Adminhtml\Category
{

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @param \Magento\Backend\App\Action\Context             $context
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Magento\Framework\View\LayoutFactory           $layoutFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    ) {
        parent::__construct($context);
        $this->resultRawFactory = $resultRawFactory;
        $this->layoutFactory    = $layoutFactory;
    }//end __construct()

    /**
     * Grid Action
     * Display list of products related to current category
     *
     * @return \Magento\Framework\Controller\Result\Raw
     */
    public function execute()
    {
        $category = $this->_initCategory(true);
        if (!$category) {
            /*
                @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect
            */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('checkoutorderattributesfields/*/', ['_current' => true, 'id' => null]);
        }

        /*
            @var \Magento\Framework\Controller\Result\Raw $resultRaw
        */
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents(
            $this->layoutFactory->create()->createBlock(
                'FME\CheckoutOrderAttributesFields\Block\Adminhtml\Attribute\Edit\Tab\Product',
                'category.product.grid'
            )->toHtml()
        );
    }//end execute()
}//end class
