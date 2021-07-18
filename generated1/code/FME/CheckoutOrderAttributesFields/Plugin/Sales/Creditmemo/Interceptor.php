<?php
namespace FME\CheckoutOrderAttributesFields\Plugin\Sales\Creditmemo;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Plugin\Sales\Creditmemo
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Plugin\Sales\Creditmemo implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\FME\CheckoutOrderAttributesFields\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($helper);
    }

    /**
     * {@inheritdoc}
     */
    public function getPdf($creditmemos = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPdf');
        if (!$pluginInfo) {
            return parent::getPdf($creditmemos);
        } else {
            return $this->___callPlugins('getPdf', func_get_args(), $pluginInfo);
        }
    }
}
