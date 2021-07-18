<?php
namespace Sm\CartQuickPro\Controller\Wishlist\Index\Cart;

/**
 * Interceptor class for @see \Sm\CartQuickPro\Controller\Wishlist\Index\Cart
 */
class Interceptor extends \Sm\CartQuickPro\Controller\Wishlist\Index\Cart implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Wishlist\Controller\WishlistProviderInterface $wishlistProvider, \Magento\Wishlist\Model\LocaleQuantityProcessor $quantityProcessor, \Magento\Wishlist\Model\ItemFactory $itemFactory, \Magento\Checkout\Model\Cart $cart, \Magento\Wishlist\Model\Item\OptionFactory $optionFactory, \Magento\Catalog\Helper\Product $productHelper, \Magento\Framework\Escaper $escaper, \Magento\Wishlist\Helper\Data $helper, \Magento\Checkout\Helper\Cart $cartHelper, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator)
    {
        $this->___init();
        parent::__construct($context, $wishlistProvider, $quantityProcessor, $itemFactory, $cart, $optionFactory, $productHelper, $escaper, $helper, $cartHelper, $formKeyValidator);
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
