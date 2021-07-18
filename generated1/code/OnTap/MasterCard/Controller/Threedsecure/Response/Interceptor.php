<?php
namespace OnTap\MasterCard\Controller\Threedsecure\Response;

/**
 * Interceptor class for @see \OnTap\MasterCard\Controller\Threedsecure\Response
 */
class Interceptor extends \OnTap\MasterCard\Controller\Threedsecure\Response implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $session, \Magento\Framework\Controller\Result\RawFactory $rawFactory)
    {
        $this->___init();
        parent::__construct($context, $session, $rawFactory);
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
