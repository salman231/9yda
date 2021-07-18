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

use Magento\Framework\Api\AttributeValue;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\SimpleDataObjectConverter;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\SerializationException;
use Magento\Framework\ObjectManager\ConfigInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Phrase;
use Magento\Framework\Reflection\MethodsMap;
use Magento\Framework\Reflection\TypeProcessor;
use Magento\Framework\Webapi\Exception as WebapiException;
use Magento\Framework\Webapi\CustomAttribute\PreprocessorInterface;
use Zend\Code\Reflection\ClassReflection;
use Magento\Framework\Webapi\CustomAttributeTypeLocatorInterface;
use Magento\Framework\Webapi\ServiceTypeToEntityTypeMap;
/**
 * Deserialize arguments from API requests.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ServiceInputProcessor extends \Magento\Framework\Webapi\ServiceInputProcessor
{
    const EXTENSION_ATTRIBUTES_TYPE = \Magento\Framework\Api\ExtensionAttributesInterface::class;

    /**
     * @var \Magento\Framework\Reflection\TypeProcessor
     */
    protected $typeProcessor;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var \Magento\Framework\Api\AttributeValueFactory
     */
    protected $attributeValueFactory;

    /**
     * @var \Magento\Framework\Webapi\CustomAttributeTypeLocatorInterface
     */
    protected $customAttributeTypeLocator;

    /**
     * @var \Magento\Framework\Reflection\MethodsMap
     */
    protected $methodsMap;

    /**
     * @var \Magento\Framework\Reflection\NameFinder
     */
    private $nameFinder;

    /**
     * @var array
     */
    private $serviceTypeToEntityTypeMap;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var PreprocessorInterface[]
     */
    private $customAttributePreprocessors;

    /**
     * @var array
     */
    private $attributesPreprocessorsMap = [];

    /**
     * Initialize dependencies.
     *
     * @param TypeProcessor $typeProcessor
     * @param ObjectManagerInterface $objectManager
     * @param AttributeValueFactory $attributeValueFactory
     * @param CustomAttributeTypeLocatorInterface $customAttributeTypeLocator
     * @param MethodsMap $methodsMap
     * @param ServiceTypeToEntityTypeMap $serviceTypeToEntityTypeMap
     * @param ConfigInterface $config
     * @param array $customAttributePreprocessors
     */
    public function __construct(
        TypeProcessor $typeProcessor,
        ObjectManagerInterface $objectManager,
        AttributeValueFactory $attributeValueFactory,
        CustomAttributeTypeLocatorInterface $customAttributeTypeLocator,
        MethodsMap $methodsMap,
        ServiceTypeToEntityTypeMap $serviceTypeToEntityTypeMap = null,
        ConfigInterface $config = null,
        array $customAttributePreprocessors = []
    ) {
        $this->typeProcessor = $typeProcessor;
        $this->objectManager = $objectManager;
        $this->attributeValueFactory = $attributeValueFactory;
        $this->customAttributeTypeLocator = $customAttributeTypeLocator;
        $this->methodsMap = $methodsMap;
        $this->serviceTypeToEntityTypeMap = $serviceTypeToEntityTypeMap
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ServiceTypeToEntityTypeMap::class);
        $this->config = $config
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ConfigInterface::class);
        $this->customAttributePreprocessors = $customAttributePreprocessors;
        parent::__construct(
            $typeProcessor,
            $objectManager,
            $attributeValueFactory,
            $customAttributeTypeLocator,
            $methodsMap,
            $serviceTypeToEntityTypeMap,
            $config,
            $customAttributePreprocessors
         );
    }

    /**
     * Convert custom attribute data array to array of AttributeValue Data Object
     *
     * @param array $customAttributesValueArray
     * @param string $dataObjectClassName
     * @return AttributeValue[]
     * @throws SerializationException
     */
    protected function convertCustomAttributeValue($customAttributesValueArray, $dataObjectClassName)
    {
        $result = [];
        $dataObjectClassName = ltrim($dataObjectClassName, '\\');

        foreach ($customAttributesValueArray as $key => $customAttribute) {
            $this->runCustomAttributePreprocessors($key, $customAttribute);
            if (!is_array($customAttribute)) {
                $customAttribute = [AttributeValue::ATTRIBUTE_CODE => $key, AttributeValue::VALUE => $customAttribute];
            }

            if (strpos($key, 'coaf') !== false && !isset($customAttribute[AttributeValue::ATTRIBUTE_CODE])) {
                
                $customAttribute = [AttributeValue::ATTRIBUTE_CODE => $key, AttributeValue::VALUE => $customAttribute];
                $result[$key] = $this->attributeValueFactory->create()
                ->setAttributeCode($key)
                ->setValue($customAttribute);
                continue;
            }
            if ($customAttribute[AttributeValue::ATTRIBUTE_CODE] == 'coaf') {
                
                $customAttribute = [AttributeValue::ATTRIBUTE_CODE => $key, AttributeValue::VALUE => $customAttribute];
                $result[$key] = $customAttribute;
                continue;
            }

            list($customAttributeCode, $customAttributeValue) = $this->processCustomAttribute($customAttribute);
            $entityType = $this->serviceTypeToEntityTypeMap->getEntityType($dataObjectClassName);
            if ($entityType) {
                $type = $this->customAttributeTypeLocator->getType(
                    $customAttributeCode,
                    $entityType
                );
            } else {
                $type = TypeProcessor::ANY_TYPE;
            }

            if ($this->typeProcessor->isTypeAny($type) || $this->typeProcessor->isTypeSimple($type)
                || !is_array($customAttributeValue)
            ) {
                try {
                    $attributeValue = $this->convertValue($customAttributeValue, $type);
                // phpcs:ignore Magento2.Exceptions.ThrowCatch
                } catch (SerializationException $e) {
                    throw new SerializationException(
                        new Phrase(
                            'Attribute "%attribute_code" has invalid value. %details',
                            ['attribute_code' => $customAttributeCode, 'details' => $e->getMessage()]
                        )
                    );
                }
            } else {
                $attributeValue = $this->_createDataObjectForTypeAndArrayValue($type, $customAttributeValue);
            }

            //Populate the attribute value data object once the value for custom attribute is derived based on type
            $result[$customAttributeCode] = $this->attributeValueFactory->create()
                ->setAttributeCode($customAttributeCode)
                ->setValue($attributeValue);
        }

        return $result;
    }
    /**
     * Derive the custom attribute code and value.
     *
     * @param string[] $customAttribute
     * @return string[]
     */
    private function processCustomAttribute($customAttribute)
    {
        $camelCaseAttributeCodeKey = lcfirst(
            SimpleDataObjectConverter::snakeCaseToUpperCamelCase(AttributeValue::ATTRIBUTE_CODE)
        );
        // attribute code key could be snake or camel case, depending on whether SOAP or REST is used.
        if (isset($customAttribute[AttributeValue::ATTRIBUTE_CODE])) {
            $customAttributeCode = $customAttribute[AttributeValue::ATTRIBUTE_CODE];
        } elseif (isset($customAttribute[$camelCaseAttributeCodeKey])) {
            $customAttributeCode = $customAttribute[$camelCaseAttributeCodeKey];
        } else {
            $customAttributeCode = null;
        }

        if (!$customAttributeCode && !isset($customAttribute[AttributeValue::VALUE])) {
            throw new SerializationException(
                new Phrase('An empty custom attribute is specified. Enter the attribute and try again.')
            );
        } elseif (!$customAttributeCode) {
            throw new SerializationException(
                new Phrase(
                    'A custom attribute is specified with a missing attribute code. Verify the code and try again.'
                )
            );
        } elseif (!array_key_exists(AttributeValue::VALUE, $customAttribute)) {
            throw new SerializationException(
                new Phrase(
                    'The "' . $customAttributeCode .
                    '" attribute code doesn\'t have a value set. Enter the value and try again.'
                )
            );
        }

        return [$customAttributeCode, $customAttribute[AttributeValue::VALUE]];
    }

    /**
     * Get map of preprocessors related to the custom attributes
     *
     * @return array
     */
    private function getAttributesPreprocessorsMap(): array
    {
        if (!$this->attributesPreprocessorsMap) {
            foreach ($this->customAttributePreprocessors as $attributePreprocessor) {
                foreach ($attributePreprocessor->getAffectedAttributes() as $attributeKey) {
                    $this->attributesPreprocessorsMap[$attributeKey][] = $attributePreprocessor;
                }
            }
        }

        return $this->attributesPreprocessorsMap;
    }

    /**
     * Prepare attribute value by loaded attribute preprocessors
     *
     * @param mixed $key
     * @param mixed $customAttribute
     */
    private function runCustomAttributePreprocessors($key, &$customAttribute)
    {
        $preprocessorsMap = $this->getAttributesPreprocessorsMap();
        if ($key && is_array($customAttribute) && array_key_exists($key, $preprocessorsMap)) {
            $preprocessorsList = $preprocessorsMap[$key];
            foreach ($preprocessorsList as $attributePreprocessor) {
                if ($attributePreprocessor->shouldBeProcessed($key, $customAttribute)) {
                    $attributePreprocessor->process($key, $customAttribute);
                }
            }
        }
    }

}
