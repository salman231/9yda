<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Plugin\Checkout;

class LayoutProcessor
{
    /**
     * @var \FME\CheckoutOrderAttributesFields\Helper\Attributes
     */
    private $helper;
    /**
     * @var \FME\CheckoutOrderAttributesFields\Helper\Data
     */
    private $dataHelper;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;
    
    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    private $filterProvider;
    
    /**
     * Data constructor.
     *
     * @param \FME\CheckoutOrderAttributesFields\Helper\Attributes $helper
     * @param \FME\CheckoutOrderAttributesFields\Helper\Data $dataHelper
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        \FME\CheckoutOrderAttributesFields\Helper\Attributes $helper,
        \FME\CheckoutOrderAttributesFields\Helper\Data $dataHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider
    ) {
        $this->helper       = $helper;
        $this->dataHelper   = $dataHelper;
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->filterProvider = $filterProvider;
    }
    /**
     * @param array $field
     * @param array $groupConfig
     * @return array
     */
    public function addBillingFields($fields, $groupConfig, &$jsLayout,$paymentGroup )
    {
        $children = [];
        foreach ($fields as $field) {
            if ($field->getIsGlobal() == 1) {
                $elementConfig['sortOrder'] = 250;
                $elementConfig['dataScope'] =
                    $groupConfig['dataScopePrefix'].
                    '.custom_attributes.coaf.'.
                    $field->getAttributeCode();
                $elementConfig['customScope'] = $groupConfig['dataScopePrefix'];
                $elementConfig['id'] = $field->getAttributeCode();
                $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
                        ['children']['payment']['children']['payments-list']['children'][$paymentGroup]
                        ['children']['form-fields']['children'][$field->getAttributeCode()]=$this->getAttributeConfig($field, $elementConfig, 0);
            }
        }
    }
    
    /**
     * @param array $field
     * @param array $jsLayout
     * @return array
     */
    public function addShippingMethodFields($field, &$jsLayout, $customer, $quote)
    {
        if (!$quote->getIsVirtual() &&
            empty($customer->getAddresses())
        ) {
            $elementConfig['sortOrder'] = 0;
            $elementConfig['dataScope'] = 'shippingAddress.custom_attributes.coaf.'.$field->getAttributeCode();
            $elementConfig['customScope'] = 'shippingAddress.custom_attributes';
            $elementConfig['id'] = $field->getAttributeCode();
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['before-shipping-method-form']['children']
            [$field->getAttributeCode()] = $this->getAttributeConfig($field, $elementConfig);
        } elseif (!$quote->getIsVirtual() &&
            !empty($customer->getAddresses())
        ) {
            if (!isset(
                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
                ['children']['shippingAddress']['children']['before-shipping-method-form']['children']
                ['coaf-shippingmethod-form-container']
            )) {
                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
                ['children']['shippingAddress']['children']['before-shipping-method-form'] =
                [
                    'component' => 'uiComponent',
                    'displayArea' => 'before-shipping-method-form',
                    'children' =>
                    [
                        'coaf-shippingmethod-form-container' => [
                            'component' =>
                                'FME_CheckoutOrderAttributesFields/js/view/coaf-checkout-shippingmethod-form',
                            'provider' => 'checkoutProvider',
                            'config' => [
                                'template'=>
                                    'FME_CheckoutOrderAttributesFields/coaf-checkout-shippingmethod-form'
                            ],
                                'children'=> [
                                'coaf-checkout-shippingmethod-form-fieldset' => [
                                    'component' => 'uiComponent',
                                    'displayArea' => 'coaf-checkout-shippingmethod-form-fields',
                                    'children'=>[
                                        
                                    ]
                                ]
                                ]
                        ]
                    ]
                ];
            }
            $elementConfig['sortOrder'] = 0;
            $elementConfig['dataScope'] = 'coaf.'.$field->getAttributeCode();
            $elementConfig['customScope'] = 'coaf';
            $elementConfig['id'] = 'coaf.'.$field->getAttributeCode();
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['before-shipping-method-form']['children']
            ['coaf-shippingmethod-form-container']['children']['coaf-checkout-shippingmethod-form-fieldset']
            ['children'][$field->getAttributeCode()] = $this->getAttributeConfig($field, $elementConfig);
        }
    }
    /**
     * @param array $field
     * @param array $jsLayout
     * @return array
     */
    public function addReviewFields($field, &$jsLayout)
    {
        if (!isset(
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['afterForm']['children']['coaf-form-container']
        )) {
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
            ['children']['payment']['children']['afterForm'] =
            [
                'component' => 'uiComponent',
                'displayArea' => 'afterForm',
                'children' =>
                [
                    'coaf-form-container' => [
                        'component' => 'FME_CheckoutOrderAttributesFields/js/view/coaf-checkout-form',
                        'provider' => 'checkoutProvider',
                        'config' => [
                            'template'=>'FME_CheckoutOrderAttributesFields/coaf-checkout-form'
                        ],
                        'children'=> [
                            'coaf-checkout-form-fieldset' => [
                                'component' => 'uiComponent',
                                'displayArea' => 'coaf-checkout-form-fields',
                                'children'=>[
                                    
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }
        $elementConfig['sortOrder'] = 0;
        $elementConfig['dataScope'] = 'coaf.'.$field->getAttributeCode();
        $elementConfig['customScope'] = 'coaf';
        $elementConfig['id'] = 'coaf.'.$field->getAttributeCode();
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['afterForm']['children']['coaf-form-container']['children']
        ['coaf-checkout-form-fieldset']['children']
        [$field->getAttributeCode()] = $this->getAttributeConfig($field, $elementConfig, 1);
        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
        ['payment']['children']['additional-payment-validators']['children']['fme-validator']
        ['component']='FME_CheckoutOrderAttributesFields/js/view/fme-validation';
    }
    
    /**
     * @param array $fields
     * @param array $jsLayout
     * @param array $customer
     * @param array $quote
     * @return array
     */
    public function addShippingFields($field, &$jsLayout, $customer, $quote)
    {
        if ($field->getIsGlobal() == 2 &&
            empty($customer->getAddresses())
        ) {
            $elementConfig['sortOrder'] = 0;
            $elementConfig['dataScope'] =
                'shippingAddress.custom_attributes.coaf.'.$field->getAttributeCode();
            $elementConfig['customScope'] = 'shippingAddress.custom_attributes';
            $elementConfig['id'] = $field->getAttributeCode();
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
            ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']
            [$field->getAttributeCode()] = $this->getAttributeConfig($field, $elementConfig);
        } elseif (!$quote->getIsVirtual() &&
            !empty($customer->getAddresses()) &&
            $field->getIsGlobal() == 2
        ) {
            if (!isset(
                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
                ['children']['shippingAddress']['children']['before-form']['children']
                ['coaf-shipping-form-container']
            )) {
                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
                ['children']['shippingAddress']['children']['before-form'] =
                [
                    'component' => 'uiComponent',
                    'displayArea' => 'before-form',
                    'children' =>
                    [
                        'coaf-shipping-form-container' => [
                            'component' =>
                                'FME_CheckoutOrderAttributesFields/js/view/coaf-checkout-shipping-form',
                            'provider' => 'checkoutProvider',
                            'config' => [
                                'template'=>'FME_CheckoutOrderAttributesFields/coaf-checkout-shipping-form'
                            ],
                                'children'=> [
                                'coaf-checkout-shipping-form-fieldset' => [
                                    'component' => 'uiComponent',
                                    'displayArea' => 'coaf-checkout-shipping-form-fields',
                                    'children'=>[
                                        
                                    ]
                                ]
                                ]
                        ]
                    ]
                ];
            }
            $elementConfig['sortOrder'] = 0;
            $elementConfig['dataScope'] = 'coaf.'.$field->getAttributeCode();
            $elementConfig['customScope'] = 'coaf';
            $elementConfig['id'] = 'coaf.'.$field->getAttributeCode();
            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
            ['children']['shippingAddress']['children']['before-form']['children']
            ['coaf-shipping-form-container']['children']['coaf-checkout-shipping-form-fieldset']['children']
            [$field->getAttributeCode()] = $this->getAttributeConfig($field, $elementConfig);
        }
    }

    /**
     * @param array $fields
     * @param array $jsLayout
     * @param array $customer
     * @param array $quote
     * @return array
     */
    public function addBillingFieldsPage($field, &$jsLayout, $customer, $quote)
    {
        if ($field->getIsGlobal() == 1) {
            $elementConfig['sortOrder'] = 0;
            $elementConfig['dataScope'] =
                'billingAddressshared.custom_attributes.coaf.'.$field->getAttributeCode();
            $elementConfig['customScope'] = 'billingAddressshared.custom_attributes';
            $elementConfig['id'] = $field->getAttributeCode();
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
            ['children']['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']
            [$field->getAttributeCode()] = $this->getAttributeConfig($field, $elementConfig, 0);
        }
    }

    /**
     * Process js Layout of block
     *
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    ) {
        if ($this->helper->getStatus()) {
            $groupId = 0;
            $fields = $this->helper->getStepAttributes();
            $customer = $this->customerSession->getCustomer();
            if ($this->customerSession->isLoggedIn()) {
                $groupId = $customer->getGroupId();
            }
            $quote = $this->checkoutSession->getQuote();
            $billingForm = $this->dataHelper->getConfig('checkout/options/display_billing_address_on');
            if (!$billingForm && isset(
                $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
                ['children']['payment']['children']['payments-list']['children']
            )) :
                $configuration = $jsLayout['components']['checkout']['children']['steps']['children']
                ['billing-step']['children']['payment']['children']['payments-list']['children'];
                foreach ($configuration as $paymentGroup => $groupConfig) {
                    if (isset($groupConfig['component']) &&
                        $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address'
                    ) {
            
                        $this->addBillingFields($fields, $groupConfig,$jsLayout,$paymentGroup);
                    }
                }
            endif;
            foreach ($fields as $field) {
                if ($billingForm && $field->getIsGlobal() == 1){
                    $this->addBillingFieldsPage($field, $jsLayout, $customer, $quote);
                } 
                if ($field->getIsGlobal() == 2) {
                    $this->addShippingFields($field, $jsLayout, $customer, $quote);
                }
                if ($field->getIsGlobal() == 3) {
                    $this->addShippingMethodFields($field, $jsLayout, $customer, $quote);
                }
                if ($field->getIsGlobal() == 4) {
                    $this->addReviewFields($field, $jsLayout);
                }
            }
            if (!isset(
            $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
            ['payment']['children']['script']['children']['coaf-script-form-container']
            )) {
                $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
                ['children']['payment']['children']['script'] =
                [
                    'component' => 'uiComponent',
                    'displayArea' => 'script',
                    'children' =>
                    [
                        'coaf-script-form-container' => [
                            'component' => 'FME_CheckoutOrderAttributesFields/js/script/coaf-templates-form',
                            'config' => [
                                'template'=>'FME_CheckoutOrderAttributesFields/script/coaftemplates'
                            ],
                            'children' =>
                            [
                                
                            ]
                        ]
                    ]
                ];
            }
        }
        return $jsLayout;
    }
    /**
     * @param array $attribute
     * @return label
     */
    public function getCurrentStoreLabel($attribute)
    {
        $storeLabels = $attribute->getStoreLabels();
        if (!empty($storeLabels) &&
            isset($storeLabels[$this->storeManager->getStore()->getId()])
        ) {
            return $storeLabels[$this->storeManager->getStore()->getId()];
        }
        return $attribute->getFrontendLabel();
    }
    /**
     * @param array $attribute
     * @param array $scope
     * @param boolean $mayBeHidden
     * @return array
     */
    public function getAttributeConfig($attribute, $scope, $mayBeHidden = 0)
    {
        $filesize = 0;
        if ($attribute->getFmeMaxSize() > 0){
            $filesize = $attribute->getFmeMaxSize() * 1024 * 1024;
        }
        
        $attributeConfig = [];
        $fieldsMainDetail[$attribute->getAttributeCode()] = [
            'attribute_id' => $attribute->getId(),
            'attribute_code' => $attribute->getAttributeCode(),
            'admin_label' => $attribute->getFrontendLabel(),
            'label' => $this->getCurrentStoreLabel($attribute),
            'type'  => $attribute->getFrontendInput(),
            'email' => $attribute->getFmeEmail(),
            'pdf' => $attribute->getFmePdf(),
            'allowedExtensions' => $attribute->getFmeExtensions(),
            'maxFileSize' => $filesize
        ];
        $this->dataHelper->setCoafFieldsMainDetails($fieldsMainDetail);
        $this->dataHelper->setCoafFields($fieldsMainDetail);
        $layouts = [
            'text' => 'FME_CheckoutOrderAttributesFields/form/element/input',
            'textarea' => 'FME_CheckoutOrderAttributesFields/form/element/textarea',
            'message' => 'FME_CheckoutOrderAttributesFields/form/element/html',
            'multiselect' => 'FME_CheckoutOrderAttributesFields/form/element/multiselect',
            'checkbox' => 'FME_CheckoutOrderAttributesFields/form/element/checkbox-set',
            'boolean' => 'FME_CheckoutOrderAttributesFields/form/element/select',
            'radio' => 'FME_CheckoutOrderAttributesFields/form/element/radio-set',
            'file' => 'FME_CheckoutOrderAttributesFields/form/element/uploader',
            'image' => 'FME_CheckoutOrderAttributesFields/form/element/uploader',
            'date' => 'FME_CheckoutOrderAttributesFields/form/element/date',
            'select' => 'FME_CheckoutOrderAttributesFields/form/element/select',
            'texteditor' => 'FME_CheckoutOrderAttributesFields/form/element/textarea'
        ];
        $options = $this->helper->getAttributeOptions($attribute->getAttributeCode(), 1);
        $attribute->getFrontendClass() != ""?
            $validationClass[$attribute->getFrontendClass()] = 'true':$validationClass = [];
        if ($attribute->getIsRequired() && $attribute->getFrontendInput() != 'boolean') {
            $validationClass['required-entry'] = $attribute->getIsRequired();
        }
        $component = [
            'select'=>'FME_CheckoutOrderAttributesFields/js/view/form/select',
            'file'  =>'FME_CheckoutOrderAttributesFields/js/view/form/file-uploader',
            'image' => 'FME_CheckoutOrderAttributesFields/js/view/form/file-uploader'
        ];
        $countryList = $attribute->getFmeCountry()!=''?$attribute->getFmeCountry():'';
        $attributeConfig = [
            'component' => isset($component[$attribute->getFrontendInput()])?
                $component[$attribute->getFrontendInput()]:'FME_CheckoutOrderAttributesFields/js/view/form/abstract',
            'config' => [
                'attribute_code' => $attribute->getAttributeCode(),
                'attributeCode'  => $attribute->getAttributeCode(),
                'acode' => $attribute->getAttributeCode(),
                'type'  => $attribute->getFrontendInput(),
                'dtype' => $attribute->getFrontendInput(),
                'dcode' => $attribute->getFmeDcode(),
                'did'   => $attribute->getFmeDid(),
                'dValue'=> $attribute->getFmeDvalue(),
                'dependable'    => $attribute->getFmeDependable(),
                'countryDepend' => $attribute->getIsUnique(),
                'countryList'   => $countryList,
                'disableCountry'=> 0,
                'validation'    => $validationClass,
                'drequired'     => $attribute->getIsRequired(),
                'template'      => 'ui/form/field',
                'depStatus'     => 0,
                'elementTmpl'   => isset($layouts[$attribute->getFrontendInput()])?
                    $layouts[$attribute->getFrontendInput()]:'ui/form/element/'.$attribute->getFrontendInput()
            ],
            'attributeCode' => $attribute->getAttributeCode(),
            'dataScope' => $scope['dataScope'],
            'label' => $this->getCurrentStoreLabel($attribute),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => $validationClass,
            'sortOrder' => $scope['sortOrder'] + $attribute->getPosition(),
            'id' => $attribute->getAttributeCode()
        ];
        if($attribute->getFmeDcode() != '' && $attribute->getFmeDvalue() !=''){
            $attributeConfig['config']['dValue'] = $this->helper->getAttributeOptionsValueId($attribute->getFmeDcode(), $attribute->getFmeDvalue());
        }
        

        if (isset($scope['id'])) {
            $attributeConfig['config']['id'] =  $scope['id'];
            $attributeConfig['id'] =  $scope['id'];
        }
        if (!empty(trim($attribute->getNote()))) {
            $attributeConfig['config']['tooltip']['description'] =  $attribute->getNote();
        }
        if (isset($scope['customScope'])) {
            $attributeConfig['config']['customScope'] = $scope['customScope'];
        }
        if (isset($scope['displayArea'])) {
            $attributeConfig['config']['displayArea'] = $scope['displayArea'];
        }
        if (in_array(
            $attribute->getFrontendInput(),
            ['multiselect', 'select', 'radio', 'checkbox', 'boolean', 'date']
        )) {
            $attributeConfig['options'] =  $options;
        }
        if (in_array(
            $attribute->getFrontendInput(),
            ['file', 'image']
        )) {
            $type = ['file'=>'document','image'=>'image'];
            $attributeConfig['config']['placeholderType'] = $type[$attribute->getFrontendInput()];
            if (trim($attribute->getFmeExtensions()) != '') {
                $attributeConfig['config']['allowedExtensions'] = str_replace(",", " ", $attribute->getFmeExtensions());
            } else {
                $attributeConfig['config']['allowedExtensions'] = true;
            }
            
            if ($filesize > 0) {
                $attributeConfig['config']['maxFileSize'] = $filesize;
            }
            $attributeConfig['config']['uploaderConfig']['url'] = $this->dataHelper->getBaseUrl().'checkoutorderattributesfields/checkout/uploader';
        }
        //$attributeConfig['config']['additionalClasses'] = 'validate-fme-fields';
        if ($mayBeHidden) {
            $attributeConfig['config']['additionalClasses'] = 'validate-fme-fields field-'.$attribute->getAttributeCode();
        } else {
            $attributeConfig['config']['additionalClasses'] = ' field-'.$attribute->getAttributeCode();
        }
        $this->addAttributeAdditionalConfig($attribute, $attributeConfig, $scope, $options);
        return $attributeConfig;
    }
    /**
     * @param array $attribute
     * @param array $attributeConfig
     */
    public function addAttributeAdditionalConfig($attribute, &$attributeConfig, $scope, $options)
    {
        if ($attribute->getDefaultValue() != '') {
            $types = ['multiselect', 'select', 'radio', 'checkbox', 'boolean'];
            if (in_array($attribute->getFrontendInput(), $types)) {
                $attributeOptions = $this->helper->getAttributeOptions($attribute->getAttributeCode(), 0);
                $selectedOptions = explode(",", $attribute->getDefaultValue());
                $newSelected = [];
                foreach ($selectedOptions as $opt) {
                    $newSelected[] = $attributeOptions[$opt];
                }
                $attributeConfig['value'] = $newSelected;
            } else if (in_array($attribute->getFrontendInput(), ['file','image']) && $attribute->getDefaultValue()!='') {
                list($width, $height, $type, $attr) = getimagesize($this->dataHelper->getMediaDefaultPath($attribute->getDefaultValue()));
                $types = ['file'=>'document','image'=>'image'];
                $attributeConfig['value'][0]['name']= $attribute->getDefaultValue();
                //$attributeConfig['value'][0]['file']= $attribute->getDefaultValue();
                $attributeConfig['value'][0]['url'] = $this->dataHelper->getMediaDefaultUrl($attribute->getDefaultValue());
                $attributeConfig['value'][0]['size']= filesize($this->dataHelper->getMediaDefaultPath($attribute->getDefaultValue()));
                $attributeConfig['value'][0]['previewType'] = $types[$attribute->getFrontendInput()];
                $attributeConfig['value'][0]['type'] = $types[$attribute->getFrontendInput()];
                
                $attributeConfig['value'][0]['previewWidth'] = $width;
                $attributeConfig['value'][0]['previewHeight'] = $height;
                $attributeConfig['value'][0]['path']= $this->dataHelper->getMediaDefaultPath($attribute->getDefaultValue());
            
            } elseif ($attribute->getFrontendInput() == 'message') {
                $attributeConfig['value'] =  $this->filterProvider->getPageFilter()->filter($attribute->getDefaultValue());
            } else {
                $attributeConfig['value'] =  $attribute->getDefaultValue();
            }

        }
        if ($attribute->getFrontendInput() == 'textarea') {
            $attributeConfig['config']['inputName'] = $scope['dataScope'];
            $attributeConfig['config']['cols'] = 6;
            $attributeConfig['config']['rows'] = 6;
        }
        if ($attribute->getFrontendInput() == 'message') {
            $attributeConfig['inputName'] = $scope['dataScope'];
            return;
        }
        if ($attribute->getFrontendInput() == 'multiselect') {
            $attributeConfig['config']['size'] = count($options)>5?count($options) : 6;
            $attributeConfig['config']['visibleHeight'] = count($options) > 5?
            'height:100px;':'height:'.count($options)*25 .'px';
        } elseif ($attribute->getFrontendInput() == 'checkbox') {
            $attributeConfig['component'] = 'FME_CheckoutOrderAttributesFields/js/view/form/checkbox-set';
           // $attributeConfig['config']['template'] = 'FME_CheckoutOrderAttributesFields/form/element/checkbox-set';
            $attributeConfig['config']['multiple'] = true;
        } elseif ($attribute->getFrontendInput() == 'radio') {
            $attributeConfig['component'] = 'FME_CheckoutOrderAttributesFields/js/view/form/checkbox-set';
           // $attributeConfig['config']['template'] = 'FME_CheckoutOrderAttributesFields/form/element/radio-set';
            $attributeConfig['config']['multiple'] = false;
        }
        if ($attribute->getFrontendInput() == 'select') {
            $attributeConfig['caption'] = __('--Please Select--');
        }
    }
}
