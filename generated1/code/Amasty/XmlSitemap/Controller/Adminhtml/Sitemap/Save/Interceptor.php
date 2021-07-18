<?php
namespace Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\Save;

/**
 * Interceptor class for @see \Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\Save
 */
class Interceptor extends \Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\XmlSitemap\Model\SitemapFactory $sitemapFactory, \Amasty\XmlSitemap\Api\SitemapRepositoryInterface $sitemapRepository)
    {
        $this->___init();
        parent::__construct($context, $sitemapFactory, $sitemapRepository);
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
