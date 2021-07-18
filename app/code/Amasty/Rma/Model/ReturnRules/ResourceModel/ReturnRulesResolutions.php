<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\ReturnRules\ResourceModel;

use Amasty\Rma\Api\Data\ReturnRulesResolutionsInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ReturnRulesResolutions
 */
class ReturnRulesResolutions extends AbstractDb
{
    const TABLE_NAME = 'amasty_rma_return_rules_resolutions';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, ReturnRulesResolutionsInterface::RULE_RESOLUTION_ID);
    }
}
