<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Block\Returns;

use Amasty\Rma\Api\ConditionRepositoryInterface;
use Amasty\Rma\Api\Data\RequestInterface;
use Amasty\Rma\Api\ReasonRepositoryInterface;
use Amasty\Rma\Api\ResolutionRepositoryInterface;
use Amasty\Rma\Model\ConfigProvider;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Model\Order\Address\Renderer as AddressRenderer;

/**
 * Class NewReturn
 */
class NewReturn extends Template
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var AddressRenderer
     */
    private $addressRenderer;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    private $imageHelper;

    /**
     * @var ReasonRepositoryInterface
     */
    private $reasonRepository;

    /**
     * @var ConditionRepositoryInterface
     */
    private $conditionRepository;

    /**
     * @var ResolutionRepositoryInterface
     */
    private $resolutionRepository;

    /**
     * @var \Magento\Cms\Helper\Page
     */
    private $pageHelper;

    /**
     * @var bool
     */
    private $isGuest;

    public function __construct(
        ConfigProvider $configProvider,
        Registry $registry,
        AddressRenderer $addressRenderer,
        ReasonRepositoryInterface $reasonRepository,
        ConditionRepositoryInterface $conditionRepository,
        ResolutionRepositoryInterface $resolutionRepository,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Cms\Helper\Page $pageHelper,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->configProvider = $configProvider;
        $this->registry = $registry;
        $this->addressRenderer = $addressRenderer;
        $this->imageHelper = $imageHelper;
        $this->reasonRepository = $reasonRepository;
        $this->conditionRepository = $conditionRepository;
        $this->resolutionRepository = $resolutionRepository;
        $this->pageHelper = $pageHelper;
        $this->isGuest = !empty($data['isGuest']);
    }

    /**
     * @return \Amasty\Rma\Api\Data\ReturnOrderInterface
     */
    public function getReturnOrder()
    {
        return $this->registry->registry(\Amasty\Rma\Controller\RegistryConstants::CREATE_RETURN_ORDER);
    }

    /**
     * @return string
     */
    public function getHistoryUrl()
    {
        if ($this->isGuest) {
            return $this->getUrl($this->configProvider->getUrlPrefix() . '/guest/history');
        } else {
            return $this->getUrl($this->configProvider->getUrlPrefix() . '/account/history');
        }
    }

    /**
     * @param $address
     *
     * @return string|null
     */
    public function getFormatAddress($address)
    {
        return $this->addressRenderer->format($address, 'html');
    }

    /**
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     *
     * @return string
     */
    public function getProductImage($product)
    {
        return $this->imageHelper->init($product, 'product_base_image')->getUrl();
    }

    /**
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     *
     * @return array
     */
    public function getAdditionalData($product)
    {
        $data = [];
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            if ($attribute->getIsVisibleOnFront()) {
                $value = $attribute->getFrontend()->getValue($product);

                if (!$product->hasData($attribute->getAttributeCode())) {
                    $value = __('N/A');
                } elseif ((string)$value == '') {
                    $value = __('No');
                } elseif ($attribute->getFrontendInput() == 'price') {
                    continue;
                }

                if ($value instanceof \Magento\Framework\Phrase || (is_string($value) && strlen($value))) {
                    $data[$attribute->getAttributeCode()] = [
                        'label' => __($attribute->getStoreLabel()),
                        'value' => $value,
                        'code' => $attribute->getAttributeCode(),
                    ];
                }
            }
        }

        return $data;
    }

    /**
     * @return \Amasty\Rma\Api\Data\ReasonInterface[]
     */
    public function getReasons()
    {
        return $this->reasonRepository->getReasonsByStoreId($this->_storeManager->getStore()->getId());
    }

    /**
     * @return \Amasty\Rma\Api\Data\ConditionInterface[]
     */
    public function getConditions()
    {
        return $this->conditionRepository->getConditionsByStoreId($this->_storeManager->getStore()->getId());
    }

    /**
     * @return \Amasty\Rma\Api\Data\ResolutionInterface[]
     */
    public function getResolutions()
    {
        return $this->resolutionRepository->getResolutionsByStoreId($this->_storeManager->getStore()->getId());
    }

    /**
     * @return ConfigProvider
     */
    public function getConfig()
    {
        return $this->configProvider;
    }

    /**
     * @return string
     */
    public function getPolicyUrl()
    {
        return $this->pageHelper->getPageUrl($this->configProvider->getReturnPolicyPage());
    }

    /**
     * @return string
     */
    public function getSaveUrl()
    {
        if ($this->isGuest) {
            return $this->_urlBuilder->getUrl(
                $this->configProvider->getUrlPrefix() .'/guest/save',
                ['secret' => $this->getRequest()->getParam('secret')]
            );
        }

        return $this->_urlBuilder->getUrl($this->configProvider->getUrlPrefix() . '/account/save');
    }

    public function getChatUploadUrl()
    {
        return $this->_urlBuilder->getUrl(
            $this->configProvider->getUrlPrefix() . '/chat/uploadtemp'
        );
    }

    public function getChatDeleteUrl()
    {
        return $this->_urlBuilder->getUrl(
            $this->configProvider->getUrlPrefix() . '/chat/deletetemp'
        );
    }

    /**
     * @param array $request
     *
     * @return string
     */
    public function getRequestViewUrl($request)
    {
        if ($this->isGuest) {
            return $this->_urlBuilder->getUrl(
                $this->configProvider->getUrlPrefix() .'/guest/view',
                ['request' => $request[RequestInterface::URL_HASH]]
            );
        } else {
            return $this->_urlBuilder->getUrl(
                $this->configProvider->getUrlPrefix() .'/account/view',
                ['request' => $request[RequestInterface::REQUEST_ID]]
            );
        }
    }
}
