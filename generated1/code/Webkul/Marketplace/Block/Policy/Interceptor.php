<?php
namespace Webkul\Marketplace\Block\Policy;

/**
 * Interceptor class for @see \Webkul\Marketplace\Block\Policy
 */
class Interceptor extends \Webkul\Marketplace\Block\Policy implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Framework\Data\Helper\PostHelper $postDataHelper, \Magento\Framework\Url\Helper\Data $urlHelper, \Magento\Customer\Model\Customer $customer, \Magento\Customer\Model\Session $session, \Magento\Framework\Stdlib\StringUtils $stringUtils, \Webkul\Marketplace\Helper\Data $mpHelper, \Webkul\Marketplace\Model\FeedbackFactory $feedbackModel, \Webkul\Marketplace\Model\ResourceModel\Product\CollectionFactory $mpProductCollection, \Webkul\Marketplace\Model\ProductFactory $mpProductModel, \Magento\Catalog\Model\ProductFactory $productFactory, array $data = [], ?\Webkul\Marketplace\Model\ResourceModel\SellerFlagReason\CollectionFactory $reasonCollection = null)
    {
        $this->___init();
        parent::__construct($context, $postDataHelper, $urlHelper, $customer, $session, $stringUtils, $mpHelper, $feedbackModel, $mpProductCollection, $mpProductModel, $productFactory, $data, $reasonCollection);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        if (!$pluginInfo) {
            return parent::getImage($product, $imageId, $attributes);
        } else {
            return $this->___callPlugins('getImage', func_get_args(), $pluginInfo);
        }
    }
}
