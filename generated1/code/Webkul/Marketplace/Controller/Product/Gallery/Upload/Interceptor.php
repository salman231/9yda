<?php
namespace Webkul\Marketplace\Controller\Product\Gallery\Upload;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Product\Gallery\Upload
 */
class Interceptor extends \Webkul\Marketplace\Controller\Product\Gallery\Upload implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Filesystem $filesystem, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Webkul\Marketplace\Helper\Data $helper, \Magento\Catalog\Model\Product\Media\Config $mediaConfig, \Magento\Framework\Json\Helper\Data $jsonHelper)
    {
        $this->___init();
        parent::__construct($context, $filesystem, $fileUploaderFactory, $helper, $mediaConfig, $jsonHelper);
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
