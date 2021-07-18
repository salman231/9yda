<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\Request\ResourceModel;

use Amasty\Rma\Api\Data\RequestInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Request
 */
class Request extends AbstractDb
{
    const TABLE_NAME = 'amasty_rma_request';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, RequestInterface::REQUEST_ID);
    }

    public function getRequestIdByHash($hash)
    {
        $select = $this->getConnection()->select()->from(['request' => $this->getMainTable()])
            ->where('request.' . RequestInterface::URL_HASH . ' = ?', $hash)
            ->reset(\Magento\Framework\DB\Select::COLUMNS)
            ->columns('request.' . RequestInterface::REQUEST_ID);

        if ($requestId = $this->getConnection()->fetchOne($select)) {
            return (int)$requestId;
        }

        return false;
    }

    public function getRequestCountByStatuses($statuses)
    {
        if (empty($statuses)) {
            return 0;
        }

        $select = $this->getConnection()->select()->from(['request' => $this->getMainTable()], 'count(*)')
            ->where('request.' . RequestInterface::STATUS . ' IN (?)', $statuses);

        return (int)$this->getConnection()->fetchOne($select);
    }
}
