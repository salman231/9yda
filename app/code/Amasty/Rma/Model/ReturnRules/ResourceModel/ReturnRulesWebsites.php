<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\ReturnRules\ResourceModel;

use Amasty\Rma\Api\Data\ReturnRulesWebsitesInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ReturnRulesWebsites
 */
class ReturnRulesWebsites extends AbstractDb
{
    const TABLE_NAME = 'amasty_rma_return_rules_websites';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, ReturnRulesWebsitesInterface::RULE_WEBSITE_ID);
    }
}
