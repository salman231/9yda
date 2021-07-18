<?php
namespace Webkul\Marketplace\Controller\Product\Attribute\Save;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Product\Attribute\Save
 */
class Interceptor extends \Webkul\Marketplace\Controller\Product\Attribute\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Encryption\EncryptorInterface $encryptor, \Webkul\Marketplace\Helper\Data $helper, \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection $attributeCollection, \Magento\Catalog\Model\ResourceModel\Eav\Attribute $eavAttribute, \Magento\Catalog\Model\Product\Url $productUrl, \Magento\Eav\Model\Entity $entityModel)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $formKeyValidator, $resultPageFactory, $encryptor, $helper, $attributeCollection, $eavAttribute, $productUrl, $entityModel);
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
