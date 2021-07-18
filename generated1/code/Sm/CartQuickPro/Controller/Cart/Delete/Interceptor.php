<?php
namespace Sm\CartQuickPro\Controller\Cart\Delete;

/**
 * Interceptor class for @see \Sm\CartQuickPro\Controller\Cart\Delete
 */
class Interceptor extends \Sm\CartQuickPro\Controller\Cart\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Checkout\Model\Cart $cart, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository)
    {
        $this->___init();
        parent::__construct($context, $scopeConfig, $checkoutSession, $storeManager, $formKeyValidator, $cart, $productRepository);
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
