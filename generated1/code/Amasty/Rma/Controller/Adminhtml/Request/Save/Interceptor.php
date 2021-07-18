<?php
namespace Amasty\Rma\Controller\Adminhtml\Request\Save;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\Request\Save
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\Request\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Rma\Api\RequestRepositoryInterface $repository, \Amasty\Rma\Model\Chat\ResourceModel\CollectionFactory $messageCollectionFactory, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \Amasty\Rma\Model\Request\Email\EmailRequest $emailRequest, \Amasty\Rma\Model\ConfigProvider $configProvider, \Magento\Framework\DataObject $dataObject, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Amasty\Rma\Api\StatusRepositoryInterface $statusRepository, \Amasty\Rma\Utils\Email $email, \Amasty\Rma\Model\OptionSource\Grid $grid)
    {
        $this->___init();
        parent::__construct($context, $repository, $messageCollectionFactory, $dataPersistor, $emailRequest, $configProvider, $dataObject, $scopeConfig, $statusRepository, $email, $grid);
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
