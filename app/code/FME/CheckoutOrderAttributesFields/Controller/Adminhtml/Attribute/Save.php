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

namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save extends \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute
{
    /**
     * @var \Magento\Catalog\Model\Product\AttributeSet\BuildFactory
     */
    private $buildFactory;

    /**
     * @var \Magento\Framework\Filter\FilterManager
     */
    private $filterManager;

    /**
     * @var \Magento\Catalog\Helper\Product
     */
    private $productHelper;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Eav\AttributeFactory
     */
    private $attributeFactory;

    /**
     * @var \Magento\Eav\Model\Adminhtml\System\Config\Source\Inputtype\ValidatorFactory
     */
    private $validatorFactory;

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory
     */
    private $groupCollectionFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    private $layoutFactory;

    /**
     * File Uploader factory.
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    private $fileUploaderFactory;
 
    private $mediaDirectory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Catalog\Model\Product\AttributeSet\BuildFactory $buildFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Catalog\Model\ResourceModel\Eav\AttributeFactory $attributeFactory
     * @param \Magento\Eav\Model\Adminhtml\System\Config\Source\Inputtype\ValidatorFactory $validatorFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory $groupCollectionFactory
     * @param \Magento\Framework\Filter\FilterManager $filterManager
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Catalog\Model\Product\AttributeSet\BuildFactory $buildFactory,
        \FME\CheckoutOrderAttributesFields\Model\ResourceModel\Eav\AttributeFactory $attributeFactory,
        \Magento\Eav\Model\Adminhtml\System\Config\Source\Inputtype\ValidatorFactory $validatorFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory $groupCollectionFactory,
        \Magento\Framework\Filter\FilterManager $filterManager,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
    ) {
        parent::__construct($context, $coreRegistry, $resultPageFactory);
        $this->buildFactory = $buildFactory;
        $this->filterManager = $filterManager;
        $this->productHelper = $productHelper;
        $this->attributeFactory = $attributeFactory;
        $this->validatorFactory = $validatorFactory;
        $this->groupCollectionFactory = $groupCollectionFactory;
        $this->layoutFactory = $layoutFactory;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->fileUploaderFactory = $fileUploaderFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!empty($data)) {
            if (!isset($data['categories_ids'])) {
                $data['categories_ids'] = [];
            }
            $data['product_ids'] = [];
            if (isset($data['category_products']) && $data['category_products'] != '') {
                $cat_array = json_decode($data['category_products'], true);
                $product_array = array_keys($cat_array);
                unset($data['category_products']);
                $data['product_ids'] = $product_array;
            }
            $attributeId = $this->getRequest()->getParam('attribute_id');
            $attributeCode = $this->getRequest()->getParam('attribute_code')
                ?: $this->generateCode($this->getRequest()->getParam('frontend_label')[0]);
            if (strlen($attributeCode) > 0) {
                $validatorAttrCode = new \Zend_Validate_Regex(['pattern' => '/^[a-z][a-z_0-9]{0,30}$/']);
                if (!$validatorAttrCode->isValid($attributeCode)) {
                    $this->messageManager->addError(
                        __(
                            'Attribute code "%1" is invalid. Please use only letters (a-z), ' .
                            'numbers (0-9) or underscore(_) in this field, first character should be a letter.',
                            $attributeCode
                        )
                    );
                    return $this->returnResult(
                        'checkoutorderattributesfields/*/edit',
                        ['attribute_id' => $attributeId, '_current' => true],
                        ['error' => true]
                    );
                }
            }
            $data['attribute_code'] = $attributeCode;
            //validate frontend_input
            if (isset($data['frontend_input'])) {
                /** @var $inputType \Magento\Eav\Model\Adminhtml\System\Config\Source\Inputtype\Validator */
                $inputType = $this->validatorFactory->create();
                if (!$inputType->isValid($data['frontend_input'])) {
                    foreach ($inputType->getMessages() as $message) {
                        $this->messageManager->addError($message);
                    }
                    return $this->returnResult(
                        'checkoutorderattributesfields/*/edit',
                        ['attribute_id' => $attributeId, '_current' => true],
                        ['error' => true]
                    );
                }
            }
            /* @var $model \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
            $model = $this->attributeFactory->create();

            if ($attributeId) {
                $model->load($attributeId);
                if (!$model->getId()) {
                    $this->messageManager->addError(__('This attribute no longer exists.'));
                    return $this->returnResult('checkoutorderattributesfields/*/', [], ['error' => true]);
                }
                // entity type check
                if ($model->getEntityTypeId() != $this->entityTypeId) {
                    $this->messageManager->addError(__('We can\'t update the attribute.'));
                    $this->_session->setAttributeData($data);
                    return $this->returnResult('checkoutorderattributesfields/*/', [], ['error' => true]);
                }
                $data['attribute_code'] = $model->getAttributeCode();
                $data['is_user_defined'] = $model->getIsUserDefined();
                $data['frontend_input'] = $model->getFrontendInput();
            } else {
                /**
                 * @todo add to helper and specify all relations for properties
                 */
                $data['source_model'] = $this->productHelper->getAttributeSourceModelByInputType(
                    $data['frontend_input']
                );
                $data['backend_model'] = $this->productHelper->getAttributeBackendModelByInputType(
                    $data['frontend_input']
                );
            }
            // check if dependent on country
            if ($data['is_unique'] > 0 && $data['is_global'] < 3) {
                $data['fme_country'] = implode(',', $data['fme_country']);
            } else {
                $data['is_unique'] = 0;
                $data['fme_country'] = '';
            }
            $data += ['is_filterable' => 0, 'is_filterable_in_search' => 0, 'apply_to' => []];
            $customTypes = [ 'checkbox'=>'varchar', 'radio' =>'int' ];
            $inputTypes = [
                'checkbox' => ['backend_model' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend'],
                'radio' => ['backend_model' => '']
            ];
            if (is_null($model->getIsUserDefined()) || $model->getIsUserDefined() != 0) {
                $data['backend_type'] = $model->getBackendTypeByInput($data['frontend_input']);
            }
            $defaultValueField = $model->getDefaultValueByInput($data['frontend_input']);

            if ($defaultValueField) {
                $data['default_value'] = $this->getRequest()->getParam($defaultValueField);
            }
            if (isset($data['fme_dvalue']) && is_array($data['fme_dvalue'])) {
                $data['fme_dvalue']  = implode(",", $data['fme_dvalue']);
                if ($data['fme_dvalue'] == "") {
                    $data['fme_dependable']  = 0;
                    $data['fme_dpath']  = '\\';
                    $data['fme_dcode']  = '';
                    $data['fme_did']  = 0;
                }
            }
            if($data['fme_dependable'] == 0) {
                $data['fme_dvalue'] = "";
                $data['fme_dpath']  = '\\';
                $data['fme_dcode']  = '';
                $data['fme_did']  = 0;
            }

            if (in_array($data['frontend_input'],['checkbox','radio'])) {
                $data['backend_type'] = $customTypes[$data['frontend_input']];
                $data['backend_model'] = $inputTypes[$data['frontend_input']]['backend_model'];
            } elseif (in_array($data['frontend_input'],['image','file'])) {
                $data['backend_type'] = $model->getBackendTypeByInput('text');
                $target = $this->mediaDirectory->getAbsolutePath('coaf/files/');
                try {
                    /** @var $uploader \Magento\MediaStorage\Model\File\Uploader */
                    if ($data['frontend_input'] == 'image') {
                        $uploader = $this->fileUploaderFactory->create(
                            ['fileId' => 'default_value_image']
                        );
                    } else {
                        $uploader = $this->fileUploaderFactory->create(
                            ['fileId' => 'default_value_file']
                        );
                    }
                    $uploader->setAllowRenameFiles(true);
                    $resul = $uploader->save($target);
                    $data['default_value'] = $resul['file'];
                } catch(\Exception $e) {
                    if ($e->getCode() == 666) {
                        $data['default_value'] = isset($data['remove_default_file']) && $data['remove_default_file']==1?
                            '':$data['default_value_text'];
                    } else {
                        $this->messageManager->addError($e->getMessage());
                        $this->_session->setAttributeData($data);
                        return $this->returnResult(
                            'additionalcustomerattributes/*/edit',
                            ['attribute_id' => $attributeId, '_current' => true],
                            ['error' => true]
                        );
                    }
                }
            }
            if (!$model->getIsUserDefined() && $model->getId()) {
                // Unset attribute field for system attributes
                unset($data['apply_to']);
            }
            $model->addData($data);
            if (!$attributeId) {
                $model->setEntityTypeId($this->entityTypeId);
                $model->setIsUserDefined(1);
            }
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the Checkout Order attribute.'));
                $this->_session->setAttributeData(false);
                if ($this->getRequest()->getParam('back', false)) {
                    return $this->returnResult(
                        'checkoutorderattributesfields/*/edit',
                        ['attribute_id' => $model->getId(), '_current' => true],
                        ['error' => false]
                    );
                }
                return $this->returnResult('checkoutorderattributesfields/*/', [], ['error' => false]);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_session->setAttributeData($data);
                return $this->returnResult(
                    'checkoutorderattributesfields/*/edit',
                    ['attribute_id' => $attributeId, '_current' => true],
                    ['error' => true]
                );
            }
        }
        return $this->returnResult('checkoutorderattributesfields/*/', [], ['error' => true]);
    }

    /**
     * @param string $path
     * @param array $params
     * @param array $response
     * @return \Magento\Framework\Controller\Result\Json|\Magento\Backend\Model\View\Result\Redirect
     */
    private function returnResult($path = '', array $params = [], array $response = [])
    {
        if ($this->isAjax()) {
            $layout = $this->layoutFactory->create();
            $layout->initMessages();
            $response['messages'] = [$layout->getMessagesBlock()->getGroupedHtml()];
            $response['params'] = $params;
            return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($response);
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath($path, $params);
    }

    /**
     * Define whether request is Ajax
     *
     * @return boolean
     */
    private function isAjax()
    {
        return $this->getRequest()->getParam('isAjax');
    }

    /**
     * Determine if authorized to perform group actions.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('FME_CheckoutOrderAttributesFields::attributes_save');
    }
}
