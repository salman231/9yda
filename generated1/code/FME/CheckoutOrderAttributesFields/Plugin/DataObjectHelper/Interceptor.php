<?php
namespace FME\CheckoutOrderAttributesFields\Plugin\DataObjectHelper;

/**
 * Interceptor class for @see \FME\CheckoutOrderAttributesFields\Plugin\DataObjectHelper
 */
class Interceptor extends \FME\CheckoutOrderAttributesFields\Plugin\DataObjectHelper implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Api\ObjectFactory $objectFactory, \Magento\Framework\Reflection\DataObjectProcessor $objectProcessor, \Magento\Framework\Reflection\TypeProcessor $typeProcessor, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor)
    {
        $this->___init();
        parent::__construct($objectFactory, $objectProcessor, $typeProcessor, $extensionFactory, $joinProcessor);
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
