<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\Request\ResourceModel;

use Amasty\Rma\Api\Data\RequestItemInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class RequestItem
 */
class RequestItem extends AbstractDb
{
    const TABLE_NAME = 'amasty_rma_request_item';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, RequestItemInterface::REQUEST_ITEM_ID);
    }

    public function removeDeletedItems($requestId, $requestItemIds)
    {
        $this->getConnection()->delete(
            $this->getMainTable(),
            [
                RequestItemInterface::REQUEST_ID . ' = ?' => (int)$requestId,
                RequestItemInterface::REQUEST_ITEM_ID . ' NOT IN (?)' => $requestItemIds
            ]
        );
    }
}
