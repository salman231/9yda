<?php
namespace Magento\Search\Helper\Data;

/**
 * Interceptor class for @see \Magento\Search\Helper\Data
 */
class Interceptor extends \Magento\Search\Helper\Data implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Helper\Context $context, \Magento\Framework\Stdlib\StringUtils $string, \Magento\Framework\Escaper $escaper, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $string, $escaper, $storeManager);
    }

    /**
     * {@inheritdoc}
     */
    public function getResultUrl($query = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResultUrl');
        if (!$pluginInfo) {
            return parent::getResultUrl($query);
        } else {
            return $this->___callPlugins('getResultUrl', func_get_args(), $pluginInfo);
        }
    }
}
