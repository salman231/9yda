<?php
namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute\Gridp;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute\Gridp
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute\Gridp implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Framework\View\LayoutFactory $layoutFactory)
    {
        $this->___init();
        parent::__construct($context, $resultRawFactory, $layoutFactory);
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
