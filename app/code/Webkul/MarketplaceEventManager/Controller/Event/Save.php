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

namespace Webkul\MarketplaceEventManager\Controller\Event;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;

/**
 * Webkul Marketplace Product Save Controller.
 */
class Save extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $_formKeyValidator;

    /**
     * @var SaveProduct
     */
    protected $_saveProduct;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    protected $_productResourceModel;

    /**
     * @param Context          $context
     * @param Session          $customerSession
     * @param FormKeyValidator $formKeyValidator
     * @param SaveProduct      $saveProduct
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        FormKeyValidator $formKeyValidator,
        SaveProduct $saveProduct,
        \Magento\Catalog\Model\ResourceModel\Product $productResourceModel,
        \Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement,
        \Webkul\Marketplace\Helper\Data $marketplaceHelper,
        \Webkul\MarketplaceEventManager\Helper\Data $helper
    ) {
        $this->_customerSession = $customerSession;
        $this->_formKeyValidator = $formKeyValidator;
        $this->_saveProduct = $saveProduct;
        $this->_productResourceModel = $productResourceModel;
        $this->helper = $helper;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->categoryLinkManagement = $categoryLinkManagement;
        parent::__construct(
            $context
        );
    }

    /**
     * seller product save action.
     *
     * @return \Magento\Framework\Controller\Result\RedirectFactory
     */
    public function execute()
    {
        $helper = $this->marketplaceHelper;
        $isPartner = $helper->isSeller();
        if ($isPartner == 1) {
            try {
                $returnArr = [];
                $productId = '';
                if ($this->getRequest()->isPost()) {
                    if (!$this->_formKeyValidator->validate($this->getRequest())) {
                        return $this->resultRedirectFactory->create()->setPath(
                            '*/*/add',
                            ['_secure' => $this->getRequest()->isSecure()]
                        );
                    }

                    $wholedata = $this->getRequest()->getParams();
                    $skuType = $helper->getSkuType();
                    $skuPrefix = $helper->getSkuPrefix();
                    if ($skuType == 'dynamic') {
                        $sku = $skuPrefix.$wholedata['product']['name'];
                        $wholedata['product']['sku'] = $this->checkSkuExist($sku);
                    }

                    list($datacol, $errors) = $this->validatePost();

                    if (empty($errors)) {
                        $returnArr = $this->_saveProduct->saveProductData(
                            $this->helper->getLoggedInSellerId(),
                            $wholedata
                        );
                        $productId = $returnArr['product_id'];
                    } else {
                        foreach ($errors as $message) {
                            $this->messageManager->addError($message);
                        }
                    }
                }
                if ($productId != '') {
                    if (!isset($wholedata['product']['category_ids'])) {
                        $wholedata['product']['category_ids'] = [];
                    }
                    $this->categoryLinkManagement->assignProductToCategories($wholedata['product']['sku'], $wholedata['product']['category_ids']);
                    if (empty($errors)) {
                        $this->messageManager->addSuccess(
                            __('Your event has been successfully saved')
                        );
                    }

                    return $this->resultRedirectFactory->create()->setPath(
                        '*/*/edit',
                        [
                            'id' => $productId,
                            '_secure' => $this->getRequest()->isSecure(),
                        ]
                    );
                } else {
                    if (isset($returnArr['error']) && isset($returnArr['message'])) {
                        if ($returnArr['error'] && $returnArr['message'] != '') {
                            $this->messageManager->addError($returnArr['message']);
                        }
                    }

                    return $this->resultRedirectFactory->create()->setPath(
                        $this->_redirect->getRefererUrl(),
                        ['_secure' => $this->getRequest()->isSecure()]
                    );
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());

                return $this->resultRedirectFactory->create()->setPath(
                    $this->_redirect->getRefererUrl(),
                    ['_secure' => $this->getRequest()->isSecure()]
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());

                return $this->resultRedirectFactory->create()->setPath(
                    $this->_redirect->getRefererUrl(),
                    ['_secure' => $this->getRequest()->isSecure()]
                );
            }
        } else {
            return $this->resultRedirectFactory->create()->setPath(
                'marketplace/account/becomeseller',
                ['_secure' => $this->getRequest()->isSecure()]
            );
        }
    }

    private function checkSkuExist($sku)
    {
        try {
            $id = $this->_productResourceModel->getIdBySku($sku);
            if ($id) {
                $avialability = 0;
            } else {
                $avialability = 1;
            }
        } catch (\Exception $e) {
            $avialability = 0;
        }
        if ($avialability == 0) {
            $sku = $sku.rand();
            $sku = $this->checkSkuExist($sku);
        }
        return $sku;
    }

    private function validatePost()
    {
        $errors = [];
        $data = [];
        foreach ($this->getRequest()->getParam('product') as $code => $value) {
            switch ($code) :
                case 'name':
                    $result = $this->nameValidateFunction($value, $code, $errors, $data);
                    $errors = $result['error'];
                    $data = $result['data'];
                    break;
                case 'description':
                    $result = $this->descriptionValidateFunction($value, $code, $errors, $data);
                    $errors = $result['error'];
                    $data = $result['data'];
                    break;
                case 'price':
                    $result = $this->priceValidateFunction($value, $code, $errors, $data);
                    $errors = $result['error'];
                    $data = $result['data'];
                    break;
                case 'weight':
                    $result = $this->weightValidateFunction($value, $code, $errors, $data);
                    $errors = $result['error'];
                    $data = $result['data'];
                    break;
                case 'stock':
                    $result = $this->stockValidateFunction($value, $code, $errors, $data);
                    $errors = $result['error'];
                    $data = $result['data'];
                    break;
                case 'sku_type':
                    $result = $this->skuTypeValidateFunction($value, $code, $errors, $data);
                    $errors = $result['error'];
                    $data = $result['data'];
                    break;
                case 'price_type':
                    $result = $this->priceTypeValidateFunction($value, $code, $errors, $data);
                    $errors = $result['error'];
                    $data = $result['data'];
                    break;
                case 'weight_type':
                    $result = $this->weightTypeValidateFunction($value, $code, $errors, $data);
                    $errors = $result['error'];
                    $data = $result['data'];
                    break;
                case 'bundle_options':
                    $result = $this->bundleOptionValidateFunction($value, $code, $errors, $data);
                    $errors = $result['error'];
                    $data = $result['data'];
            endswitch;
        }

        return [$data, $errors];
    }

    private function nameValidateFunction($value, $code, $errors, $data)
    {
        if (trim($value) == '') {
            $errors[] = __('Name has to be completed');
        } else {
            $data[$code] = $value;
        }
        return ['error' => $errors, 'data' => $data];
    }

    private function descriptionValidateFunction($value, $code, $errors, $data)
    {
        if (trim($value) == '') {
            $errors[] = __(
                'Description has to be completed'
            );
        } else {
            $data[$code] = $value;
        }
        return ['error' => $errors, 'data' => $data];
    }

    private function priceValidateFunction($value, $code, $errors, $data)
    {
        if (!preg_match('/^([0-9])+?[0-9.]*$/', $value)) {
            $errors[] = __(
                'Price should contain only decimal numbers'
            );
        } else {
            $data[$code] = $value;
        }
        return ['error' => $errors, 'data' => $data];
    }

    private function weightValidateFunction($value, $code, $errors, $data)
    {
        if (!preg_match('/^([0-9])+?[0-9.]*$/', $value)) {
            $errors[] = __(
                'Weight should contain only decimal numbers'
            );
        } else {
            $data[$code] = $value;
        }
        return ['error' => $errors, 'data' => $data];
    }

    private function stockValidateFunction($value, $code, $errors, $data)
    {
        if (!preg_match('/^([0-9])+?[0-9.]*$/', $value)) {
            $errors[] = __(
                'Product stock should contain only integers'
            );
        } else {
            $data[$code] = $value;
        }
        return ['error' => $errors, 'data' => $data];
    }

    private function skuTypeValidateFunction($value, $code, $errors, $data)
    {
        if (trim($value) == '') {
            $errors[] = __('Sku Type has to be selected');
        } else {
            $data[$code] = $value;
        }
        return ['error' => $errors, 'data' => $data];
    }

    private function priceTypeValidateFunction($value, $code, $errors, $data)
    {
        if (trim($value) == '') {
            $errors[] = __('Price Type has to be selected');
        } else {
            $data[$code] = $value;
        }
        return ['error' => $errors, 'data' => $data];
    }

    private function weightTypeValidateFunction($value, $code, $errors, $data)
    {
        if (trim($value) == '') {
            $errors[] = __('Weight Type has to be selected');
        } else {
            $data[$code] = $value;
        }
        return ['error' => $errors, 'data' => $data];
    }

    private function bundleOptionValidateFunction($value, $code, $errors, $data)
    {
        if (trim($value) == '') {
            $errors[] = __('Default Title has to be completed');
        } else {
            $data[$code] = $value;
        }
        return ['error' => $errors, 'data' => $data];
    }
}
