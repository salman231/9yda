<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Rewrite\Framework;

use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\AttributeValue;
use Magento\Framework\Api\SimpleDataObjectConverter;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\SerializationException;
use Magento\Framework\Reflection\TypeProcessor;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Webapi\Exception as WebapiException;
use Magento\Framework\Phrase;
use Zend\Code\Reflection\ClassReflection;
use Magento\Framework\Reflection\MethodsMap;
/**
 * Deserialize arguments from API requests.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DataObjectHelper extends \Magento\Framework\Api\DataObjectHelper
{
    /**
     * @param object $dataObject
     * @param string $getterMethodName
     * @param string $methodName
     * @param array $value
     * @param string $interfaceName
     * @return $this
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function setComplexValue(
        $dataObject,
        $getterMethodName,
        $methodName,
        array $value,
        $interfaceName
    ) {
        if ($interfaceName == null) {
            $interfaceName = get_class($dataObject);
        }
        $returnType = $this->methodsMapProcessor->getMethodReturnType($interfaceName, $getterMethodName);
        if ($this->typeProcessor->isTypeSimple($returnType)) {
            $dataObject->$methodName($value);
            return $this;
        }

        if ($this->typeProcessor->isArrayType($returnType)) {
            $type = $this->typeProcessor->getArrayItemType($returnType);
            $objects = [];
            foreach ($value as $arrayElementData) {
                $object = $this->objectFactory->create($type, []);
                $this->populateWithArray($object, $arrayElementData, $type);
                $objects[] = $object;
            }
            $dataObject->$methodName($objects);
            return $this;
        }

        if (is_subclass_of($returnType, \Magento\Framework\Api\ExtensibleDataInterface::class)) {
            $object = $this->objectFactory->create($returnType, []);
            $this->populateWithArray($object, $value, $returnType);
        } elseif (is_subclass_of($returnType, \Magento\Framework\Api\ExtensionAttributesInterface::class)) {
            foreach ($value as $extensionAttributeKey => $extensionAttributeValue) {
                $extensionAttributeGetterMethodName
                    = 'get' . \Magento\Framework\Api\SimpleDataObjectConverter::snakeCaseToUpperCamelCase(
                        $extensionAttributeKey
                    );
                $methodReturnType = $this->methodsMapProcessor->getMethodReturnType(
                    $returnType,
                    $extensionAttributeGetterMethodName
                );
                $extensionAttributeType = $this->typeProcessor->isArrayType($methodReturnType)
                    ? $this->typeProcessor->getArrayItemType($methodReturnType)
                    : $methodReturnType;
                if ($this->typeProcessor->isTypeSimple($extensionAttributeType)) {
                    $value[$extensionAttributeKey] = $extensionAttributeValue;
                } else {
                    if ($this->typeProcessor->isArrayType($methodReturnType)) {
                        if ($extensionAttributeKey == 'coaf') {
                            $val = json_decode($extensionAttributeValue,true);
                            $data = [];
                            $i = 0;
                            foreach ($val as $key => $coaf) {
                                $data[$i] = ['attributeCode'=> $key,'value'=> $coaf['value']];
                            }
                            $extensionAttributeValue = [];
                            $extensionAttributeValue[]=$data;

                            //echo "<pre>";print_r($extensionAttributeValue);exit;
                            //continue;
                        }
                        foreach ($extensionAttributeValue as $key => $extensionAttributeArrayValue) {
                            $extensionAttribute = $this->objectFactory->create($extensionAttributeType, []);
                            $this->populateWithArray(
                                $extensionAttribute,
                                $extensionAttributeArrayValue,
                                $extensionAttributeType
                            );
                            if ($extensionAttributeKey == 'coaf') {

                                $value[$extensionAttributeKey] = $this->objectFactory->create(
                                    $extensionAttributeType,
                                    ['data' => $extensionAttributeValue]
                                );
                            } else {
                                $value[$extensionAttributeKey][$key] = $extensionAttribute;
                            }
                            
                        }
                    } else {
                        $value[$extensionAttributeKey] = $this->objectFactory->create(
                            $extensionAttributeType,
                            ['data' => $extensionAttributeValue]
                        );
                    }
                }
            }
            $object = $this->extensionFactory->create(get_class($dataObject), ['data' => $value]);
        } else {
            $object = $this->objectFactory->create($returnType, $value);
        }
        $dataObject->$methodName($object);
        return $this;
    }
}
