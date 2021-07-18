<?php
namespace Webkul\Marketplace\Controller\Product\Reportflag;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Product\Reportflag
 */
class Interceptor extends \Webkul\Marketplace\Controller\Product\Reportflag implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Webkul\Marketplace\Helper\Data $helper, \Webkul\Marketplace\Helper\Email $mpEmailHelper, \Magento\Framework\Json\Helper\Data $jsonHelper, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Webkul\Marketplace\Model\ProductFlagsFactory $productFlags)
    {
        $this->___init();
        parent::__construct($context, $helper, $mpEmailHelper, $jsonHelper, $date, $productFlags);
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
