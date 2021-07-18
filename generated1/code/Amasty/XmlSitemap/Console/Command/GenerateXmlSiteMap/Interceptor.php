<?php
namespace Amasty\XmlSitemap\Console\Command\GenerateXmlSiteMap;

/**
 * Interceptor class for @see \Amasty\XmlSitemap\Console\Command\GenerateXmlSiteMap
 */
class Interceptor extends \Amasty\XmlSitemap\Console\Command\GenerateXmlSiteMap implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\XmlSitemap\Model\ResourceModel\Sitemap\CollectionFactory $sitemapCollection, \Magento\Framework\App\State $state, $name = null)
    {
        $this->___init();
        parent::__construct($sitemapCollection, $state, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function run(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'run');
        if (!$pluginInfo) {
            return parent::run($input, $output);
        } else {
            return $this->___callPlugins('run', func_get_args(), $pluginInfo);
        }
    }
}
