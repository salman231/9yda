<?php
namespace Amasty\Rma\Controller\Chat\Save;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Chat\Save
 */
class Interceptor extends \Amasty\Rma\Controller\Chat\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Api\ChatRepositoryInterface $chatRepository, \Amasty\Rma\Api\CustomerRequestRepositoryInterface $requestRepository, \Amasty\Rma\Utils\FileUpload $fileUpload, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($chatRepository, $requestRepository, $fileUpload, $context);
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
