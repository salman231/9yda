<?php
namespace Webkul\Marketplace\Controller\Seller\Usernameverify;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Seller\Usernameverify
 */
class Interceptor extends \Webkul\Marketplace\Controller\Seller\Usernameverify implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Json\Helper\Data $jsonHelper, \Webkul\Marketplace\Model\ResourceModel\Seller\CollectionFactory $sellerCollectionFactory)
    {
        $this->___init();
        parent::__construct($context, $jsonHelper, $sellerCollectionFactory);
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
