<?php
namespace Meetanshi\Knet\Controller\Adminhtml\Payment\Request;

/**
 * Interceptor class for @see \Meetanshi\Knet\Controller\Adminhtml\Payment\Request
 */
class Interceptor extends \Meetanshi\Knet\Controller\Adminhtml\Payment\Request implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Sales\Model\OrderFactory $orderFactory, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Meetanshi\Knet\Helper\Data $helper, $params = [])
    {
        $this->___init();
        parent::__construct($context, $orderFactory, $formKeyValidator, $helper, $params);
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
