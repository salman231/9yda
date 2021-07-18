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

class Attributes extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var \Magento\Config\Model\Config\Source\Yesno
     */
    private $storeManager;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory
     */
    private $eavAttributeRepository;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;
    /**
     * Helper
     *
     * @var \FME\CheckoutOrderAttributesFields\Helper\Data
     */
    private $helper;
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $timeZoneInterface;
    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \FME\CheckoutOrderAttributesFields\Helper\Data $helper,
        \FME\CheckoutOrderAttributesFields\Model\ResourceModel\Attribute\CollectionFactory $collectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Eav\Api\AttributeRepositoryInterface $eavAttributeRepository,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timeZoneInterface
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager      = $storeManager;
        $this->helper            = $helper;
        $this->customerSession   = $customerSession;
        $this->checkoutSession   = $checkoutSession;
        $this->timeZoneInterface = $timeZoneInterface;
        $this->eavAttributeRepository = $eavAttributeRepository;
        parent::__construct($context);
    }

    /**
     * @return boolean
     */
    public function getStatus()
    {
        return $this->helper->getStatus();
    }//end getConfig()

    public function getStepAttributes()
    {
        $groupId = 0;
        if ($this->customerSession->isLoggedIn()) {
            $groupId = $this->customerSession->getCustomer()->getGroupId();
        }
        $catalog_ids = $this->getProductIds();
        return $this->collectionFactory->create()
            ->addVisibleFilter()
            ->addStoreFilters($this->storeManager->getStore()->getId())
            ->addCustomerGroupFilter($groupId)
            ->addCatalogFilter($catalog_ids)
            ->applySort();
    }
    public function getProductIds()
    {
        $items = $this->checkoutSession->getQuote()->getAllItems();
        $productId['product_ids'] = [];
        $productId['category_ids'] = [];
        foreach ($items as $item) {
            $productId['product_ids'][] = $item->getProductId();
            $current = $item->getProduct()->getCategoryIds();
            $previous = $productId['category_ids'];
            $productId['category_ids'] = array_unique(array_merge($current, $previous));
        }
        return $productId;
    }
    public function getAdminCreateOrderAttributes($store)
    {
        $groupId = 0;
        return $this->collectionFactory->create()
            ->addVisibleFilter()
            ->addStoreFilters($store)
            ->addCustomerGroupFilter($groupId)
            ->applySort();
    }
    public function getBillingAttributes()
    {
        return $this->collectionFactory->create()->addBillingFilter()->addVisibleFilter()->applySort();
    }

    public function getShippingAttributes()
    {
        return $this->collectionFactory->create()->addShippingFilter()->addVisibleFilter()->applySort();
    }

    public function getShippingMethodAttributes()
    {
        return $this->collectionFactory->create()->addShippingMethodFilter()->addVisibleFilter()->applySort();
    }

    public function getPaymentStepAttributes()
    {
        return $this->collectionFactory->create()->addPaymentStepFilter()->addVisibleFilter()->applySort();
    }
    public function getAttributeOptions($attributeCode, $mode = 0)
    {
        $attribute = $this->eavAttributeRepository->get(
            \FME\CheckoutOrderAttributesFields\Model\Attribute::ENTITY,
            $attributeCode
        );
        $attribute->setStoreId($this->storeManager->getStore()->getId());
        $options = $attribute->getSource()->getAllOptions(false);
        $optionLabel = [];
        foreach ($options as $value) {
            if ($mode == 0) {
                $optionLabel[$value['value']] = $value['label'];
            } elseif ($mode == 1) {
                $optionLabel[] = ['value' => $value['label'], 'label' => $value['label']];
            } else {
                $optionLabel[] = ['value' => $value['value'], 'label' => $value['label']];
            }
        }
        if ($attribute->getFrontendInput() == "boolean") {
            $optionLabel = [];
            if ($mode == 0) {
                $optionLabel[0] = __('No');
                $optionLabel[1] = __('Yes');
            } elseif ($mode == 1) {
                $optionLabel[] = ['value' => __('No'), 'label' => __('No')];
                $optionLabel[] = ['value' => __('Yes'), 'label' => __('Yes')];
            } else {
                $optionLabel[] = ['value' => 0, 'label' => __('No')];
                $optionLabel[] = ['value' => 1, 'label' => __('Yes')];
            }
        }
        if ($attribute->getFrontendInput() == "date") {
            $optionLabel['dateFormat'] = $this->timeZoneInterface->getDateFormat(\IntlDateFormatter::SHORT);
        }
        return $optionLabel;
    }

    public function getAttributeOptionsValueId($attributeCode, $ids)
    {
        $attribute = $this->eavAttributeRepository->get(
            \FME\CheckoutOrderAttributesFields\Model\Attribute::ENTITY,
            $attributeCode
        );
        $attribute->setStoreId($this->storeManager->getStore()->getId());
        $options = $attribute->getSource()->getAllOptions(false);
        $optionLabel = [];
        $ids = explode(",", $ids);

        foreach ($options as $value) {
            if (in_array($value['value'], $ids)) {
                $attributeOptionValues[] = $value['label'];
            }
        }
        return implode(",", $attributeOptionValues);
    }
}
