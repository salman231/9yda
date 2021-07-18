<?php
namespace FME\CheckoutOrderAttributesFields\Model\ResourceModel\Eav;

/**
 * Factory class for @see \FME\CheckoutOrderAttributesFields\Model\ResourceModel\Eav\Attribute
 */
class AttributeFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\FME\\CheckoutOrderAttributesFields\\Model\\ResourceModel\\Eav\\Attribute')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \FME\CheckoutOrderAttributesFields\Model\ResourceModel\Eav\Attribute
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
