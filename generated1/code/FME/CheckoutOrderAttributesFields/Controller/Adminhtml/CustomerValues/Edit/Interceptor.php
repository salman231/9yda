<?php
namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\CustomerValues\Edit;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\CustomerValues\Edit
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\CustomerValues\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $resultJsonFactory, $orderRepository, $logger);
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
