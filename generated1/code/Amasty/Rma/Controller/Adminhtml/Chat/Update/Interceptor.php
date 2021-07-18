<?php
namespace Amasty\Rma\Controller\Adminhtml\Chat\Update;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\Chat\Update
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\Chat\Update implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Api\ChatRepositoryInterface $chatRepository, \Amasty\Rma\Model\Request\CustomerRequestRepository $customerRequestRepository, \Amasty\Rma\Utils\FileUpload $fileUpload, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($chatRepository, $customerRequestRepository, $fileUpload, $context);
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
