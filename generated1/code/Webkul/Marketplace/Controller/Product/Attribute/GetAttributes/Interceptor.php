<?php
namespace Webkul\Marketplace\Controller\Product\Attribute\GetAttributes;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Product\Attribute\GetAttributes
 */
class Interceptor extends \Webkul\Marketplace\Controller\Product\Attribute\GetAttributes implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attributeCollection, \Webkul\Marketplace\Helper\Data $helper, \Magento\Framework\Json\Helper\Data $jsonHelper, \Webkul\Marketplace\Helper\Orders $ordersHelper)
    {
        $this->___init();
        parent::__construct($context, $attributeCollection, $helper, $jsonHelper, $ordersHelper);
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
