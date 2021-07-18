<?php
namespace Amasty\Rma\Controller\Chat\UploadTemp;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Chat\UploadTemp
 */
class Interceptor extends \Amasty\Rma\Controller\Chat\UploadTemp implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Rma\Utils\FileUpload $fileUpload, \Amasty\Rma\Model\ConfigProvider $configProvider)
    {
        $this->___init();
        parent::__construct($context, $fileUpload, $configProvider);
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
