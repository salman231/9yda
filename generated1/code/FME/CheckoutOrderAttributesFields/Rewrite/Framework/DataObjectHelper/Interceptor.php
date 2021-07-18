<?php
namespace FME\CheckoutOrderAttributesFields\Rewrite\Framework\DataObjectHelper;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Rewrite\Framework\DataObjectHelper
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Rewrite\Framework\DataObjectHelper implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Api\ObjectFactory $objectFactory, \Magento\Framework\Reflection\DataObjectProcessor $objectProcessor, \Magento\Framework\Reflection\TypeProcessor $typeProcessor, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor, \Magento\Framework\Reflection\MethodsMap $methodsMapProcessor)
    {
        $this->___init();
        parent::__construct($objectFactory, $objectProcessor, $typeProcessor, $extensionFactory, $joinProcessor, $methodsMapProcessor);
    }

    /**
     * {@inheritdoc}
     */
    public function mergeDataObjects($interfaceName, $firstDataObject, $secondDataObject)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'mergeDataObjects');
        if (!$pluginInfo) {
            return parent::mergeDataObjects($interfaceName, $firstDataObject, $secondDataObject);
        } else {
            return $this->___callPlugins('mergeDataObjects', func_get_args(), $pluginInfo);
        }
    }
}
