<?php
namespace Sm\ListingTabs\Controller\Index\Index;

/**
 * Interceptor class for @see \Sm\ListingTabs\Controller\Index\Index
 */
class Interceptor extends \Sm\ListingTabs\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Framework\View\LayoutInterface $layout, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Framework\App\Response\Http $response, \Magento\Framework\App\CacheInterface $cacheInterFace, \Sm\ListingTabs\Block\ListingTabs $listingTabs)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $jsonEncoder, $layout, $layoutFactory, $response, $cacheInterFace, $listingTabs);
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
