<?php
namespace FME\CheckoutOrderAttributesFields\Controller\Checkout\Uploader;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Controller\Checkout\Uploader
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Controller\Checkout\Uploader implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \FME\CheckoutOrderAttributesFields\Helper\Data $helper, \Magento\Customer\Model\Session $customerSession, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\Json\Helper\Data $jsonHelper, \FME\CheckoutOrderAttributesFields\Model\ImageUploader $imageUploader)
    {
        $this->___init();
        parent::__construct($context, $helper, $customerSession, $checkoutSession, $jsonHelper, $imageUploader);
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
