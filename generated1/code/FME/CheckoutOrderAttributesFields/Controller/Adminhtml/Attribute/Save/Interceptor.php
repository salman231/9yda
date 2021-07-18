<?php
namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute\Save;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute\Save
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Catalog\Model\Product\AttributeSet\BuildFactory $buildFactory, \FME\CheckoutOrderAttributesFields\Model\ResourceModel\Eav\AttributeFactory $attributeFactory, \Magento\Eav\Model\Adminhtml\System\Config\Source\Inputtype\ValidatorFactory $validatorFactory, \Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory $groupCollectionFactory, \Magento\Framework\Filter\FilterManager $filterManager, \Magento\Catalog\Helper\Product $productHelper, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Framework\Filesystem $filesystem, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $buildFactory, $attributeFactory, $validatorFactory, $groupCollectionFactory, $filterManager, $productHelper, $layoutFactory, $filesystem, $fileUploaderFactory);
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
