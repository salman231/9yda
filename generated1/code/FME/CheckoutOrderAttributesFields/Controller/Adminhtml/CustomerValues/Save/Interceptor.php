<?php
namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\CustomerValues\Save;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\CustomerValues\Save
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\CustomerValues\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \FME\CheckoutOrderAttributesFields\Model\CustomerValues $customerValues, \Magento\Framework\View\LayoutFactory $layoutFactory, \FME\CheckoutOrderAttributesFields\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $resultJsonFactory, $customerValues, $layoutFactory, $helper);
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
