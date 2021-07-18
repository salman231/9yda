<?php
namespace Amasty\Rma\Controller\Chat\DeleteTemp;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Chat\DeleteTemp
 */
class Interceptor extends \Amasty\Rma\Controller\Chat\DeleteTemp implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\Rma\Utils\FileUpload $fileUpload)
    {
        $this->___init();
        parent::__construct($context, $fileUpload);
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
