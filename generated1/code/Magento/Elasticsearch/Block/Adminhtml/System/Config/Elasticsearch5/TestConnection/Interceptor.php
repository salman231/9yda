<?php
namespace Magento\Elasticsearch\Block\Adminhtml\System\Config\Elasticsearch5\TestConnection;

/**
 * Interceptor class for @see \Magento\Elasticsearch\Block\Adminhtml\System\Config\Elasticsearch5\TestConnection
 */
class Interceptor extends \Magento\Elasticsearch\Block\Adminhtml\System\Config\Elasticsearch5\TestConnection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        if (!$pluginInfo) {
            return parent::render($element);
        } else {
            return $this->___callPlugins('render', func_get_args(), $pluginInfo);
        }
    }
}
