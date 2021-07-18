<?php
namespace Amasty\SeoHtmlSitemap\Controller\Index\Index;

/**
 * Interceptor class for @see \Amasty\SeoHtmlSitemap\Controller\Index\Index
 */
class Interceptor extends \Amasty\SeoHtmlSitemap\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $pageFactory, \Amasty\SeoHtmlSitemap\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $pageFactory, $helper);
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
