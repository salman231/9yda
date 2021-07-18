<?php
/**
 *
 * @category : FME
 * @Package  : FME_AdditionalCustomerAttributes
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create\Element;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Template;

/**
 * EAV Entity Attribute Form Renderer Block for File
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class File extends \FME\CheckoutOrderAttributesFields\Block\Adminhtml\Order\Create\Element\AbstractRenderer
{
    /**
     * @var \Magento\Framework\Url\EncoderInterface
     */
    private $urlEncoder;
    /**
     * @var \Magento\Framework\Url\EncoderInterface
     */
    private $storeManager;

    public $helper;

    /**
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \FME\CheckoutOrderAttributesFields\Helper\Data $helper,
        array $data = []
    ) {
        $this->urlEncoder = $urlEncoder;
        $this->helper     = $helper;
        $this->storeManager  = $context->getStoreManager();
        parent::__construct($context, $data);
    }
    /**
     * Return escaped value
     *
     * @return string
     */
    public function getEscapedValue()
    {
        if ($this->getValue()) {
            if ($this->storeManager->getStore()->getId() > 0) {
                return $this->escapeHtml(
                    $this->storeManager->getStore()->getBaseUrl(). "pub/media/coaf/"
                )."default/".$this->getValue();
            } else {
                return $this->escapeHtml(
                    $this->storeManager->getStore(1)->getBaseUrl(). "pub/media/coaf/"
                )."default/".$this->getValue();
            }
        }
        return '';
    }

    /**
     * Return escaped value
     *
     * @return string
     */
    public function getAllowedFileExtensions()
    {
        return $this->getCurrentAttribute()->getFmeExtensions();
    }
    /**
     * Return attribute Max size
     *
     * @return string
     */
    public function getMaxSize()
    {
        return $this->getCurrentAttribute()->getFmeMaxSize();
    }
    /**
     * Return image preview
     *
     * @return array
     */
    public function getDefaultImagePreview($default = null)
    {

        $attributeConfig = [];
        $path = $this->helper->getMediaPath($default);
        if ($default == null) {
            $default = $this->getCurrentAttribute()->getDefaultValue();
            $path = $this->helper->getMediaDefaultPath($default);
        }
        if ($default != '') {
            list($width, $height, $type, $attr) = getimagesize($path);
            $types = ['file'=>'document','image'=>'image'];
            $attributeConfig[0]['name']= $default;
            //$attributeConfig[0]['file']= $this->getCurrentAttribute()->getDefaultValue();
            $attributeConfig[0]['url'] = $this->helper->getMediaUrl($default);
            $attributeConfig[0]['size']= filesize($path);
            $attributeConfig[0]['previewType'] = $types[$this->getCurrentAttribute()->getFrontendInput()];
            $attributeConfig[0]['type'] = $types[$this->getCurrentAttribute()->getFrontendInput()];
            $attributeConfig[0]['attributeCode'] = $this->getAttributeName();
            $attributeConfig[0]['acode'] = $this->getCurrentAttribute()->getAttributeCode();
            $attributeConfig[0]['dependable'] = $this->getCurrentAttribute()->getFmeDependable();
            $attributeConfig[0]['dcode'] = $this->getCurrentAttribute()->getFmeDcode();
            $attributeConfig[0]['did'] = $this->getCurrentAttribute()->getFmeDid();
            $attributeConfig[0]['dValue'] = $this->getCurrentAttribute()->getFmeDvalue();
            $attributeConfig[0]['previewWidth'] = $width;
            $attributeConfig[0]['previewHeight'] = $height;
            $attributeConfig[0]['path']= $path;
        }
        return $attributeConfig;
    }
    /**
     * Initialize attribute array
     *
     * @param string
     * @return array
     */
    public function getMagentoInit($mode = 'image', $default = null)
    {
        $validationClass['required-entry'] = $this->isRequired();
        $filesize = false;
        $allowedExtensions = false;
        if (trim($this->getAllowedFileExtensions()) != '') {
            $allowedExtensions = str_replace(",", " ", trim($this->getAllowedFileExtensions()));
        }
        if ($this->getMaxSize() > 0) {
            $filesize = $this->getMaxSize() * 1024 * 1024;
        }
        $script = [];
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['component'] = "FME_CheckoutOrderAttributesFields/js/form/file-uploader";
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['template'] = "FME_CheckoutOrderAttributesFields/form/element/uploader";
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['dataScope'] = $this->getAttributeName();
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['dataId'] = $this->getAttributeId();
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['previewTmpl'] = "ui/form/element/uploader/preview";
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['placeholderType'] = $mode;
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['allowedExtensions'] = $allowedExtensions;
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['maxFileSize'] = $filesize;
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['browse'] = $this->getAttributeId().'_browse';
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['isRequired'] = $this->isRequired();
        if($this->isRequired()) {
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['validation'] = $validationClass;
        }
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['attributeCode'] = $this->getAttributeName();
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['acode'] = $this->getCurrentAttribute()->getAttributeCode();
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['dependable'] = $this->getCurrentAttribute()->getFmeDependable();
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['dcode'] = $this->getCurrentAttribute()->getFmeDcode();
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['did'] = $this->getCurrentAttribute()->getFmeDid();
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['dValue'] = $this->getCurrentAttribute()->getFmeDvalue();
        $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['uploaderConfig']['url'] = $this->getUrl('checkoutorderattributesfields/sales/upload');
        if ($default != '') {
            $script['#upload-wrapper-'.$this->getAttributeId()]['Magento_Ui/js/core/app']['components'][$this->getAttributeId()]['value'] = $this->getDefaultImagePreview($default);
        }
        return $script;
    }
}
