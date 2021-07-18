<?php
namespace Magento\Sales\Model\Order\Invoice\Total\Shipping;

/**
 * Interceptor class for @see \Magento\Sales\Model\Order\Invoice\Total\Shipping
 */
class Interceptor extends \Magento\Sales\Model\Order\Invoice\Total\Shipping implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(array $data = [])
    {
        $this->___init();
        parent::__construct($data);
    }

    /**
     * {@inheritdoc}
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'collect');
        if (!$pluginInfo) {
            return parent::collect($invoice);
        } else {
            return $this->___callPlugins('collect', func_get_args(), $pluginInfo);
        }
    }
}
