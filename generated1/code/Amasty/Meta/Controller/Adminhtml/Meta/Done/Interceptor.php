<?php
namespace Amasty\Meta\Controller\Adminhtml\Meta\Done;

/**
 * Interceptor class for @see \Amasty\Meta\Controller\Adminhtml\Meta\Done
 */
class Interceptor extends \Amasty\Meta\Controller\Adminhtml\Meta\Done implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Meta\Helper\UrlKeyHandler $helperUrl, \Magento\Indexer\Model\Indexer\StateFactory $stateFactory, \Magento\Framework\Json\Helper\Data $jsonHelper)
    {
        $this->___init();
        parent::__construct($context, $helperUrl, $stateFactory, $jsonHelper);
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
