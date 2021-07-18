<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\CustomerValues;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Controller\Result;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;
class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'FME_CheckoutOrderAttributesFields::customervalues';
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        OrderRepositoryInterface $orderRepository,
        LoggerInterface $logger
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;
        parent::__construct($context);
    }
    
    /**
     * Init layout, menu and breadcrumb
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('FME_CheckoutOrderAttributesFields::customervalues');
        $resultPage->addBreadcrumb(__('FME'), __('FME'));
        $resultPage->addBreadcrumb(__('Customer Values'), __('Customer Values'));
        return $resultPage;
    }

    /**
     * Initialize order model instance
     *
     * @return \Magento\FME\Api\Data\OrderInterface|false
     */
    protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        try {
            $order = $this->orderRepository->get($id);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This order no longer exists.'));
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
            return false;
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage(__('This order no longer exists.'));
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        $this->_coreRegistry->register('sales_order', $order);
        $this->_coreRegistry->register('current_order', $order);
        return $order;
    }

    /**
     * @return bool
     */
    protected function isValidPostRequest()
    {
        $formKeyIsValid = $this->_formKeyValidator->validate($this->getRequest());
        $isPost = $this->getRequest()->isPost();
        return ($formKeyIsValid && $isPost);
    }

    /**
     * View order detail
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultJson = $this->resultJsonFactory->create();
        $order = $this->_initOrder();
        $storeId = 0;
        if ($order) {
            $storeId = $order->getStoreId();
        }
        try {
            $result['html'] = $resultPage->getLayout()
                ->createBlock("FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create\Fields")
                ->setSelectedOrder($order)
                ->setStore($storeId)
                ->setTemplate("FME_CheckoutOrderAttributesFields::sales/create/editfields.phtml")->toHtml();
            $result['success'] = 'true';
        } catch (\Exception $e) {
            $result = ['error' => 'true', 'message' => $e->getMessage()];
        }

        return $resultJson->setData($result);
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
