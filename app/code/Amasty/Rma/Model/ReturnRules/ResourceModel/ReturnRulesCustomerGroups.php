<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\ReturnRules\ResourceModel;

use Amasty\Rma\Api\Data\ReturnRulesCustomerGroupsInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ReturnRulesCustomerGroups
 */
class ReturnRulesCustomerGroups extends AbstractDb
{
    const TABLE_NAME = 'amasty_rma_return_rules_customer_groups';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, ReturnRulesCustomerGroupsInterface::RULE_CUSTOMER_GROUP_ID);
    }
}
