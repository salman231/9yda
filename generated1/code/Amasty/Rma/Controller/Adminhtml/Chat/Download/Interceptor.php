<?php
namespace Amasty\Rma\Controller\Adminhtml\Chat\Download;

/**
 * Interceptor class for @see \Amasty\Rma\Controller\Adminhtml\Chat\Download
 */
class Interceptor extends \Amasty\Rma\Controller\Adminhtml\Chat\Download implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Rma\Model\Chat\ResourceModel\MessageFileCollectionFactory $messageFileCollectionFactory, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Framework\Filesystem $filesystem, \Magento\Backend\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($messageFileCollectionFactory, $fileFactory, $filesystem, $context);
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
