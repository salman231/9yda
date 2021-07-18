<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 � fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Helper;
use Magento\Backend\Model\UrlInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * ScopeConfig
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    private $backendUrl;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Magento\Backend\Model\Session
     */
    private $backendSession;

    /**
     * @var \FME\CheckoutOrderAttributesFields\Model\CustomerValues
     */
    private $customerValues;
    /**
     * Escaper
     *
     * @var \Magento\Framework\Escaper
     */
    private $escaper;
    private $storeManager;
    private $directory;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Backend\Model\Session $backendSession,
        UrlInterface $backendUrl,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Stdlib\DateTime\Timezone $timezone,
        \FME\CheckoutOrderAttributesFields\Model\CustomerValues $customerValues,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem\DirectoryList $directory,
        \Magento\Framework\Escaper $escaper
    ) {
        $this->scopeConfig    = $context->getScopeConfig();
        $this->customerSession= $customerSession;
        $this->checkoutSession= $checkoutSession;
        $this->backendSession = $backendSession;
        $this->customerValues = $customerValues;
        $this->backendUrl   = $backendUrl;
        $this->storeManager = $storeManager;
        $this->timezone  = $timezone;
        $this->date      = $date;
        $this->directory = $directory;
        $this->escaper   = $escaper;
        parent::__construct($context);
    }

    /**
     * @param $config
     * @return string
     */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue(
            $config,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }//end getConfig()

    /**
     * @return array
     */
    public function setCoafFields($data)
    {
        $exitingValues = [];
        if ($this->checkoutSession->getCoaf() != "") {
            $exitingValues = $this->checkoutSession->getCoaf();
        }
        $this->arrayMergeRecursiveValues($data, $exitingValues);
        $this->checkoutSession->setCoaf($exitingValues);
    }//end setCoafFields()

    /**
     * @return void
     */
    public function arrayMergeRecursiveValues($user, &$default)
    {
        foreach ($user as $key => $value) {
            if (is_array($value)) {
                $this->arrayMergeRecursiveValues($user[$key], $default[$key]);
            } else {
                if (isset($default['type']) && in_array($default['type'],['date','text','textarea'])) {
                    $default[$key] = $this->escaper->escapeHtml($value);
                } else {
                    $default[$key] = $value;
                }
            }
        }
    }
    public function getProductsGridUrl() {
    return $this->backendUrl->getUrl('checkoutorderattributesfields/attribute/products', ['_current' => true]);
        }

    public function setCoreCoafFieldsMainDetails($attribute, $storeid)
    {
        $filesize = 0;
        if ($attribute->getFmeMaxSize() > 0){
            $filesize = $attribute->getFmeMaxSize() * 1024 * 1024;
        }
        $fieldsMainDetail[$attribute->getAttributeCode()] = [
            'attribute_id' => $attribute->getId(),
            'attribute_code' => $attribute->getAttributeCode(),
            'admin_label' => $attribute->getFrontendLabel(),
            'label' => $this->getCurrentStoreLabel($attribute, $storeid),
            'email' => $attribute->getFmeEmail(),
            'pdf' => $attribute->getFmePdf(),
            'store'=>$storeid,
            'type' => $attribute->getFrontendInput(),
            'allowedExtensions' => $attribute->getFmeExtensions(),
            'maxFileSize' => $filesize
        ];
        $exitingValues = [];
        if ($this->backendSession->getCoafMainDetails() != "") {
            $exitingValues = $this->backendSession->getCoafMainDetails();
        }
        $this->arrayMergeRecursiveValues($fieldsMainDetail, $exitingValues);
        $this->backendSession->setCoafMainDetails($exitingValues);
    }
    /**
     * @param array $attribute
     * @return label
     */
    public function getCurrentStoreLabel($attribute, $storeId)
    {
        $storeLabels = $attribute->getStoreLabels();
        if (!empty($storeLabels) &&
            isset($storeLabels[$storeId])
        ) {
            return $storeLabels[$storeId];
        }
        return $attribute->getFrontendLabel();
    }
    public function getCoreCoafFieldsMainDetails()
    {
        return $this->backendSession->getCoafMainDetails();
    }

    public function setAdminCoaf($data)
    {
        return $this->backendSession->setAdminCoaf($data);
    }
    public function getAdminCoaf()
    {
        return $this->backendSession->getAdminCoaf();
    }

    public function getOptionLabels($optionId, $storeId, $needArray = false)
    {
        return $this->customerValues->getOptionValueById($optionId, $storeId, $needArray);
    }
    /**
     * @return void
     */
    public function setCoafFieldsMainDetails($data)
    {
        $exitingValues = [];
        if ($this->checkoutSession->getCoafMainDetails() != "") {
            $exitingValues = $this->checkoutSession->getCoafMainDetails();
        }
        $this->arrayMergeRecursiveValues($data, $exitingValues);
        $this->checkoutSession->setCoafMainDetails($exitingValues);
    }//end setCoafFields()
    /**
     * @return void
     */
    public function getCoafFieldsMainDetails()
    {
        return $this->checkoutSession->getCoafMainDetails();
    }//end setCoafFields()

    /**
     * @return void
     */
    public function getCoafFields()
    {
        return $this->checkoutSession->getCoaf();
    }//end setCoafFields()
    /**
     * @return boolean
     */
    public function getStatus()
    {
        return $this->getConfig('checkoutorderattributesfields/general/active');
    }//end getConfig()

    /**
     * @return boolean
     */
    public function getHeading()
    {
        return $this->getConfig('checkoutorderattributesfields/general/heading');
    }//end getConfig()

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()
           ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_LINK);
    }

    public function getMediaUrl($file)
    {
        return $this->storeManager->getStore()
           ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."coaf/files/".$file;
    }

    public function getMediaPath($file)
    {
        return $this->directory->getPath('media')."/coaf/files/".$file;
    }

    public function getMediaDefaultUrl($file)
    {
        return $this->storeManager->getStore()
           ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."coaf/default/".$file;
    }

    public function getMediaDefaultPath($file)
    {
        return $this->directory->getPath('media')."/coaf/default/".$file;
    }
}
