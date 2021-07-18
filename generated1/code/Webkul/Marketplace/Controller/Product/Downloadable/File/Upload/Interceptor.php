<?php
namespace Webkul\Marketplace\Controller\Product\Downloadable\File\Upload;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Product\Downloadable\File\Upload
 */
class Interceptor extends \Webkul\Marketplace\Controller\Product\Downloadable\File\Upload implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Webkul\Marketplace\Helper\Data $helper, \Magento\Downloadable\Model\Link $link, \Magento\Downloadable\Model\Sample $sample, \Magento\Downloadable\Helper\File $fileHelper, \Magento\MediaStorage\Helper\File\Storage\Database $mediaStorage, \Magento\Framework\Json\Helper\Data $jsonHelper)
    {
        $this->___init();
        parent::__construct($context, $fileUploaderFactory, $helper, $link, $sample, $fileHelper, $mediaStorage, $jsonHelper);
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
