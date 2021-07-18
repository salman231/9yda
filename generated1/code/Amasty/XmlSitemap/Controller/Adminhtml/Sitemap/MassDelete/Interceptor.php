<?php
namespace Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\MassDelete;

/**
 * Interceptor class for @see \Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\MassDelete
 */
class Interceptor extends \Amasty\XmlSitemap\Controller\Adminhtml\Sitemap\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Psr\Log\LoggerInterface $logger, \Amasty\XmlSitemap\Model\ResourceModel\Sitemap\CollectionFactory $collectionFactory, \Amasty\XmlSitemap\Model\ResourceModel\SitemapFactory $sitemapFactory, \Amasty\XmlSitemap\Model\Repository\SitemapRepository $sitemapRepository)
    {
        $this->___init();
        parent::__construct($context, $filter, $logger, $collectionFactory, $sitemapFactory, $sitemapRepository);
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
