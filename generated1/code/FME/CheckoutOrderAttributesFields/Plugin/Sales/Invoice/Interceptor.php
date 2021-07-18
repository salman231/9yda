<?php
namespace FME\CheckoutOrderAttributesFields\Plugin\Sales\Invoice;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Plugin\Sales\Invoice
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Plugin\Sales\Invoice implements \Magento\Framework\Interception\InterceptorInterface
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
    public function getPdf($invoices = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPdf');
        if (!$pluginInfo) {
            return parent::getPdf($invoices);
        } else {
            return $this->___callPlugins('getPdf', func_get_args(), $pluginInfo);
        }
    }
}
