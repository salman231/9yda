<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create;

use Magento\Backend\Block\Template\Context;
/**
 * Adminhtml catalog product attributes block
 *
 */
class Fields extends \Magento\Framework\View\Element\Template
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
     * @var int
     */
    protected $storeId = 0;
    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $selectedOrder = null;
    protected $formKey;
    protected $sessionQuote;
    /**
     * Data constructor.
     *
     * @param Context $context
     * @param \FME\CheckoutOrderAttributesFields\Helper\Attributes $helper
     * @param \FME\CheckoutOrderAttributesFields\Helper\Data $dataHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        \FME\CheckoutOrderAttributesFields\Helper\Attributes $helper,
        \FME\CheckoutOrderAttributesFields\Helper\Data $dataHelper,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Backend\Model\Session\Quote $sessionQuote,
        array $data = []
    ) {
        $this->helper       = $helper;
        $this->dataHelper   = $dataHelper;
        $this->storeManager = $context->getStoreManager();
        $this->formKey      = $formKey;
        $this->sessionQuote = $sessionQuote;
        parent::__construct($context, $data);
    }
    /**
     * get Label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->dataHelper->getHeading();
    }
    /**
     * get attributes
     *
     * @return array
     */
    public function getAvailableAttributes()
    {
        $fields = [];
        if ($this->helper->getStatus()) {
            $fields = $this->helper->getAdminCreateOrderAttributes($this->getStore());
        }
        return $fields;
    }

    /**
     * get element html
     * @param object $attribute
     * @return string
     */
    public function getElement($attribute)
    {
        // Logic if order is edit, get order id from session and load the order here.
        $order  = $this->getSelectedOrder();
        $layout = $this->getLayout();
        $template = 'FME_CheckoutOrderAttributesFields::sales/create/elements/'.$attribute->getFrontendInput().'.phtml';
        /** @var \Magento\Framework\View\Element\Template $block */
        $class = ucwords($attribute->getFrontendInput());
        $block = $layout->createBlock("\FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create\Element\\".$class)
            ->setName("element.".$attribute->getAttributeCode())
            ->setCurrentAttribute($attribute)
            ->setSelectedOrder($order)
            ->setTemplate($template)->toHtml();
        return $block;
    }
    /**
     * Get Post Url
     * @return string
     */
    public function getPostUrl()
    {
        return $this->getUrl('checkoutorderattributesfields/customervalues/save');
    }

    /**
     * get form key
     *
     * @return string
     */
    public function getAdminFormKey()
    {
         return $this->formKey->getFormKey();
    }

    /**
     * get attribute script details
     * @param object $attribute
     * @param string $mode
     * @return array
     */
    public function getMagentoInit($attribute, $mode = 'image')
    {
        $validationClass['required-entry'] = $attribute->getIsRequired();
        $filesize = false;
        $allowedExtensions = false;
        if (trim($attribute->getFmeExtensions()) != '') {
            $allowedExtensions = str_replace(",", " ", trim($attribute->getFmeExtensions()));
        }
        if ($attribute->getFmeMaxSize() > 0) {
            $filesize = $attribute->getFmeMaxSize() * 1024 * 1024;
        }
        $script = [];
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['component'] = "FME_CheckoutOrderAttributesFields/js/form/file-uploader";
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['template'] = "FME_CheckoutOrderAttributesFields/form/element/uploader";
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['dataScope'] = $this->getAttributeName($attribute);
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['dataId'] = $attribute->getAttributeId();
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['previewTmpl'] = "ui/form/element/uploader/preview";
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['placeholderType'] = $mode;
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['allowedExtensions'] = $allowedExtensions;
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['maxFileSize'] = $filesize;
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['validation'] = $validationClass;
        $script['#upload-wrapper-'.$attribute->getAttributeId()]['Magento_Ui/js/core/app']['components'][$attribute->getAttributeId()]['uploaderConfig']['url'] = $this->getUrl('checkoutorderattributesfields/sales/upload');
        return $script;
    }

    /**
     * get attribute name
     * @param object $attribute
     * @return string
     */
    public function getAttributeName($attribute)
    {
        $format = '%1$s';
        return sprintf($format, 'order[fme]['.$attribute->getAttributeCode().']');
    }
}
