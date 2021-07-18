<?php
namespace Amasty\Rma\Controller\Adminhtml\Request\ShippingLabel\Upload;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\Request\ShippingLabel\Upload
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\Request\ShippingLabel\Upload implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Utils\FileUpload $fileUpload, \Amasty\Rma\Model\Request\Repository $repository, \Magento\Framework\View\Asset\Repository $assetRepository, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($fileUpload, $repository, $assetRepository, $context);
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
