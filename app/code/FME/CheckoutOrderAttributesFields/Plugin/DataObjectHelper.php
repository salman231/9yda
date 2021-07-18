<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Plugin;

class DataObjectHelper extends \Magento\Framework\Api\DataObjectHelper
{
    /**
     * @var ObjectFactory
     */
    protected $objectFactory;

    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $objectProcessor;

    /**
     * @var \Magento\Framework\Reflection\TypeProcessor
     */
    protected $typeProcessor;

    /**
     * @var \Magento\Framework\Api\ExtensionAttributesFactory
     */
    protected $extensionFactory;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $joinProcessor;


    /**
     * @param ObjectFactory $objectFactory
     * @param \Magento\Framework\Reflection\DataObjectProcessor $objectProcessor
     * @param \Magento\Framework\Reflection\TypeProcessor $typeProcessor
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor
     */
    public function __construct(
        \Magento\Framework\Api\ObjectFactory $objectFactory,
        \Magento\Framework\Reflection\DataObjectProcessor $objectProcessor,
        \Magento\Framework\Reflection\TypeProcessor $typeProcessor,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $joinProcessor
    ) {
        $this->objectFactory = $objectFactory;
        $this->objectProcessor = $objectProcessor;
        $this->typeProcessor = $typeProcessor;
        $this->extensionFactory = $extensionFactory;
        $this->joinProcessor = $joinProcessor;
    }
    
    /**
     * @param $subject
     * @param $interfaceName
     * @param $firstDataObject
     * @param $secondDataObject
     * @return array
     */
    public function beforeMergeDataObjects(
        \Magento\Framework\Api\DataObjectHelper $subject,
        $interfaceName,
        $firstDataObject,
        $secondDataObject
    ) { 
        switch ($interfaceName) {
            case '\Magento\Quote\Api\Data\AddressInterface':
            case '\Magento\Checkout\Api\Data\ShippingInformationInterface':
            case '\Magento\Checkout\Api\Data\PaymentDetailsInterface':
            case 'Magento\Sales\Api\Data\OrderInterface':
            case 'Magento\Sales\Api\Data\OrderExtension':
                
                if ($secondDataObject->getExtensionAttributes()->getCoaf() != '') {
                    $coafs = $secondDataObject->getExtensionAttributes()->getCoaf();
                    $coaf = json_decode($coafs,true);
                    $data = [];
                    foreach ($coaf as $key => $coaf) {
                        $data[$key] = $coaf;
                    }
                    $secondObjectArray['extension_attributes']['coaf'] = $data;
                    $secondDataObject->getExtensionAttributes()->setCoaf($data);
                    $secondDataObject->setExtensionAttributes($secondDataObject->getExtensionAttributes());   
                }
            break;
        }
        return [$interfaceName, $firstDataObject, $secondDataObject];
    }
}
