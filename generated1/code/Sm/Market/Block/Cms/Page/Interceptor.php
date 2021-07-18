<?php
namespace Sm\Market\Block\Cms\Page;

/**
 * Interceptor class for @see \Sm\Market\Block\Cms\Page
 */
class Interceptor extends \Sm\Market\Block\Cms\Page implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Context $context, \Magento\Cms\Model\Page $page, \Magento\Cms\Model\Template\FilterProvider $filterProvider, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Cms\Model\PageFactory $pageFactory, \Magento\Framework\View\Page\Config $pageConfig, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $page, $filterProvider, $storeManager, $pageFactory, $pageConfig, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        if (!$pluginInfo) {
            return parent::toHtml();
        } else {
            return $this->___callPlugins('toHtml', func_get_args(), $pluginInfo);
        }
    }
}
