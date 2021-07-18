<?php
namespace Amasty\Rma\Controller\Adminhtml\Status\Index;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\Status\Index
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\Status\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Model\Status\ResourceModel\CollectionFactory $collectionFactory, \Amasty\Rma\Model\OptionSource\State $state, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($collectionFactory, $state, $context);
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
