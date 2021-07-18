<?php
namespace Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\Run;

/**
 * Interceptor class for @see \Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\Run
 */
class Interceptor extends \Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\Run implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\XmlSitemap\Api\SitemapRepositoryInterface $sitemapRepository)
    {
        $this->___init();
        parent::__construct($context, $sitemapRepository);
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
