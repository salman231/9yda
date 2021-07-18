<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */

// @codingStandardsIgnoreFile

namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\CustomerValues;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Controller\ResultFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends \Magento\Backend\App\Action
{

    /**
     * @var \Magento\Catalog\Model\ResourceModel\OrdersFactory
     */
    private $customerValues;

    private $helper;
    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    private $layoutFactory;
    private $resultJsonFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Catalog\Model\ResourceModel\OrdersFactory $sectionsFactory
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \FME\CheckoutOrderAttributesFields\Model\CustomerValues $customerValues,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \FME\CheckoutOrderAttributesFields\Helper\Data $helper
    ) {
        parent::__construct($context);
        $this->customerValues = $customerValues;
        $this->layoutFactory = $layoutFactory;
        $this->helper = $helper;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function execute() {

        $coafFields = $this->getRequest()->getPostValue();
        $coafDetails = $this->helper->getCoreCoafFieldsMainDetails();
        $resultRedirect = $this->resultRedirectFactory->create();
        $result = $this->resultJsonFactory->create();
        if ($this->getRequest()->getParam('order_id') && $this->getRequest()->getParam('store_id')) {
            
            try {
                $this->customerValues->saveAllAdminOrderValue($coafFields['order']['fme'], $this->getRequest()->getParam('order_id'), $this->getRequest()->getParam('store_id'), $coafDetails);
                $this->messageManager->addSuccess(__('Records were successfully saved.'));
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __($e . 'Something went wrong while saving the Custom Values.'));
            }
        }
        
        $resultRedirect->setPath(
                'sales/order/view',
                array('order_id'=>$this->getRequest()->getParam('order_id'))
            );
        return $resultRedirect;
    }

    /**
     * Determine if authorized to perform group actions.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('FME_CheckoutOrderAttributesFields::customervalues');
    }
}
