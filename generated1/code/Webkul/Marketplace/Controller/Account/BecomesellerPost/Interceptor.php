<?php
namespace Webkul\Marketplace\Controller\Account\BecomesellerPost;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Account\BecomesellerPost
 */
class Interceptor extends \Webkul\Marketplace\Controller\Account\BecomesellerPost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Webkul\Marketplace\Model\SellerFactory $sellerFactory, \Webkul\Marketplace\Model\ResourceModel\Seller\CollectionFactory $sellerCollectionFactory, \Webkul\Marketplace\Helper\Data $helper, \Webkul\Marketplace\Helper\Email $mpEmailHelper, \Magento\Customer\Model\Url $customerUrl, \Magento\Backend\Model\Url $backendUrl)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $formKeyValidator, $date, $sellerFactory, $sellerCollectionFactory, $helper, $mpEmailHelper, $customerUrl, $backendUrl);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
