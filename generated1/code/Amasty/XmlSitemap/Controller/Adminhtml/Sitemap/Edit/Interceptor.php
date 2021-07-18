<?php
namespace Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\Edit;

/**
 * Interceptor class for @see \Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\Edit
 */
class Interceptor extends \Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\XmlSitemap\Api\SitemapRepositoryInterface $sitemapRepository, \Magento\Framework\Registry $coreRegistry, \Amasty\XmlSitemap\Model\SitemapFactory $sitemapFactory)
    {
        $this->___init();
        parent::__construct($context, $sitemapRepository, $coreRegistry, $sitemapFactory);
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
