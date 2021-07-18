<?php
namespace Magento\Framework\View\Page\Title;

/**
 * Interceptor class for @see \Magento\Framework\View\Page\Title
 */
class Interceptor extends \Magento\Framework\View\Page\Title implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->___init();
        parent::__construct($scopeConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'get');
        if (!$pluginInfo) {
            return parent::get();
        } else {
            return $this->___callPlugins('get', func_get_args(), $pluginInfo);
        }
    }
}
