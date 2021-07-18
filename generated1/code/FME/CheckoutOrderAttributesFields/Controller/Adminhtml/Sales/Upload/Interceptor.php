<?php
namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Sales\Upload;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Sales\Upload
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Sales\Upload implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \FME\CheckoutOrderAttributesFields\Helper\Data $helper, \Magento\Framework\Json\Helper\Data $jsonHelper, \FME\CheckoutOrderAttributesFields\Model\ImageUploader $imageUploader)
    {
        $this->___init();
        parent::__construct($context, $helper, $jsonHelper, $imageUploader);
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
