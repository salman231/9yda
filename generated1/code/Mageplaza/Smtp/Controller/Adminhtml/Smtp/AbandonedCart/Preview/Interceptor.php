<?php
namespace Mageplaza\Smtp\Controller\Adminhtml\Smtp\AbandonedCart\Preview;

/**
 * Interceptor class for @see \Mageplaza\Smtp\Controller\Adminhtml\Smtp\AbandonedCart\Preview
 */
class Interceptor extends \Mageplaza\Smtp\Controller\Adminhtml\Smtp\AbandonedCart\Preview implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Mail\Template\FactoryInterface $templateFactory, \Magento\Email\Model\Template\SenderResolver $senderResolver, \Magento\Quote\Model\QuoteFactory $quoteFactory)
    {
        $this->___init();
        parent::__construct($context, $templateFactory, $senderResolver, $quoteFactory);
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
