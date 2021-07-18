<?php
namespace FME\CheckoutOrderAttributesFields\Plugin\Sales\Shipment;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Plugin\Sales\Shipment
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Plugin\Sales\Shipment implements \Magento\Framework\Interception\InterceptorInterface
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
    public function getPdf($shipments = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPdf');
        if (!$pluginInfo) {
            return parent::getPdf($shipments);
        } else {
            return $this->___callPlugins('getPdf', func_get_args(), $pluginInfo);
        }
    }
}
