<?php
namespace Webkul\Marketplace\Controller\Account\Chart;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Account\Chart
 */
class Interceptor extends \Webkul\Marketplace\Controller\Account\Chart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Webkul\Marketplace\Block\Account\Dashboard\Diagrams $diagrams, \Webkul\Marketplace\Block\Account\Dashboard\LocationChart $locationChart, \Webkul\Marketplace\Block\Account\Dashboard\CategoryChart $categoryChart, \Magento\Framework\Json\Helper\Data $jsonHelper)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $diagrams, $locationChart, $categoryChart, $jsonHelper);
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
