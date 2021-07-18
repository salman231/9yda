<?php
namespace OnTap\MasterCard\Controller\Threedsecure\Form;

/**
 * Interceptor class for @see \OnTap\MasterCard\Controller\Threedsecure\Form
 */
class Interceptor extends \OnTap\MasterCard\Controller\Threedsecure\Form implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\RawFactory $pageFactory, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Checkout\Model\Session $session)
    {
        $this->___init();
        parent::__construct($context, $pageFactory, $layoutFactory, $session);
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
