<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MarketplaceEventManager
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MarketplaceEventManager\Model;

use Webkul\MarketplaceEventManager\Api\Data\MpeventInterface;

class Mpevent extends \Magento\Framework\Model\AbstractModel implements MpeventInterface
{
    /**
     * No route page id
     */
    const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * Test Record cache tag
     */
    const CACHE_TAG = 'marketplace_mpevent';

    /**
     * @var string
     */
    protected $_cacheTag = 'marketplace_mpevent';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'marketplace_mpevent';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Webkul\MarketplaceEventManager\Model\ResourceModel\Mpevent');
    }

    /**
     * Load object data
     *
     * @param int|null $id
     * @param string $field
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteStore();
        }
        return parent::load($id, $field);
    }
    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getEntityId()];
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::ID);
    }
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
    public function getQrcode()
    {
        return parent::getData(self::QRCODE);
    }
    public function setQrcode($id)
    {
        return $this->setData(self::QRCODE, $qrcode);
    }
    public function getItemId()
    {
        return parent::getData(self::ITEM_ID);
    }
    public function setItemId($id)
    {
        return $this->setData(self::ITEM_ID, $id);
    }
    public function getOrderId()
    {
        return parent::getData(self::ORDER_ID);
    }
    public function setOrderId($id)
    {
        return $this->setData(self::ORDER_ID, $id);
    }
    public function getOptionId()
    {
        return parent::getData(self::OPTION_ID);
    }
    public function setOptionId($id)
    {
        return $this->setData(self::OPTION_ID, $id);
    }
    public function getOptionQty()
    {
        return parent::getData(self::OPTION_QTY);
    }
    public function setOptionQty($qty)
    {
        return $this->setData(self::OPTION_QTY, $qty);
    }
    public function getSellerId()
    {
        return parent::getData(self::SELLER_ID);
    }
    public function setSellerId($id)
    {
        return $this->setData(self::SELLER_ID, $id);
    }
    public function getStatus()
    {
        return parent::getData(self::STATUS);
    }
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
    public function getCreatedAt()
    {
        return parent::getData(self::CREATED_AT);
    }
    public function setCreatedAt($createdat)
    {
        return $this->setData(self::CREATED_AT, $createdat);
    }
    public function getUpdatedAt()
    {
        return parent::getData(self::UPDATED_AT);
    }
    public function setUpdatedAt($updatedat)
    {
        return $this->setData(self::UPDATED_AT, $updatedat);
    }
}
