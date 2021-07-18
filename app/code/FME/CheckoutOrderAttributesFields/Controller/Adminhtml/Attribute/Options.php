<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute;

use Magento\Framework\DataObject;

class Options extends \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    private $layoutFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    ) {
        parent::__construct($context, $coreRegistry, $resultPageFactory);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->layoutFactory = $layoutFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        $post = $this->getRequest()->getParams();
        $response = new DataObject();
        if ($post['id'] > 0 ) {
            
            $response->setError(false);
            $model = $this->_objectManager->create(
                'FME\CheckoutOrderAttributesFields\Model\ResourceModel\Eav\Attribute'
            )->setEntityTypeId(
                $this->entityTypeId
            );
            $model->load($post['id']);
            if ($post['id'] == $post['oldid']) {
                $model->setCustomerValue($post['oldvalue']);
            }
            $resultPage = $this->resultPageFactory->create();
            $layout = $resultPage->getLayout();
            $template = 'FME_CheckoutOrderAttributesFields::sales/create/elements/multiselect.phtml';
            /** @var \Magento\Framework\View\Element\Template $block */
            $block = $layout->createBlock("\FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create\Element\Dependable")
                ->setName("fme_dvalue")
                ->setCurrentAttribute($model)
                ->setTemplate($template)->toHtml();

            $response->setHtml($block);
            $response->setAttributeCode($model->getAttributeCode());
            $response->setFmeDpath($model->getFmeDpath() . $model->getAttributeId() ."\\");
            $response->setHtmlMessage($layout->getMessagesBlock()->getGroupedHtml());
        } else {
            $this->messageManager->addError(__('No attribute was selected.'));
            $layout = $this->layoutFactory->create();
            $layout->initMessages();
            $response->setError(true);
            $response->setHtmlMessage($layout->getMessagesBlock()->getGroupedHtml());
        }
        return $this->resultJsonFactory->create()->setJsonData($response->toJson());
    }
    
    /**
     * Determine if authorized to perform group actions.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('FME_CheckoutOrderAttributesFields::attributes_add');
    }
}
