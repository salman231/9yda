<?php
namespace Amasty\SeoToolKit\Controller\Redirect\Index;

/**
 * Interceptor class for @see \Amasty\SeoToolKit\Controller\Redirect\Index
 */
class Interceptor extends \Amasty\SeoToolKit\Controller\Redirect\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Search\Helper\Data $searchHelper)
    {
        $this->___init();
        parent::__construct($context, $searchHelper);
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
