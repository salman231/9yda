<?php
namespace Amasty\Rma\Controller\Adminhtml\Reason\Save;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\Reason\Save
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\Reason\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Rma\Api\ReasonRepositoryInterface $repository, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor)
    {
        $this->___init();
        parent::__construct($context, $repository, $storeManager, $dataPersistor);
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
