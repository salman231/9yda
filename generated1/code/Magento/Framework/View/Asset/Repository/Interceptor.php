<?php
namespace Magento\Framework\View\Asset\Repository;

/**
 * Interceptor class for @see \Magento\Framework\View\Asset\Repository
 */
class Interceptor extends \Magento\Framework\View\Asset\Repository implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\UrlInterface $baseUrl, \Magento\Framework\View\DesignInterface $design, \Magento\Framework\View\Design\Theme\ListInterface $themeList, \Magento\Framework\View\Asset\Source $assetSource, \Magento\Framework\App\Request\Http $request, \Magento\Framework\View\Asset\FileFactory $fileFactory, \Magento\Framework\View\Asset\File\FallbackContextFactory $fallbackContextFactory, \Magento\Framework\View\Asset\File\ContextFactory $contextFactory, \Magento\Framework\View\Asset\RemoteFactory $remoteFactory)
    {
        $this->___init();
        parent::__construct($baseUrl, $design, $themeList, $assetSource, $request, $fileFactory, $fallbackContextFactory, $contextFactory, $remoteFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function createRemoteAsset($url, $contentType)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'createRemoteAsset');
        if (!$pluginInfo) {
            return parent::createRemoteAsset($url, $contentType);
        } else {
            return $this->___callPlugins('createRemoteAsset', func_get_args(), $pluginInfo);
        }
    }
}
