<?php
namespace Amasty\Rma\Model\ReturnRules\ResourceModel;

/**
 * Factory class for @see \Amasty\Rma\Model\ReturnRules\ResourceModel\ReturnRulesCustomerGroupsCollection
 */
class ReturnRulesCustomerGroupsCollectionFactory
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Amasty\\Rma\\Model\\ReturnRules\\ResourceModel\\ReturnRulesCustomerGroupsCollection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Amasty\Rma\Model\ReturnRules\ResourceModel\ReturnRulesCustomerGroupsCollection
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
