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
namespace Webkul\MarketplaceEventManager\Api\Data;

interface MpeventInterface
{
    /**
    * Constants for keys of data array. Identical to the name of the getter in snake case
    */
    const ID          = 'id';
    const QRCODE      = 'qrcode';
    const ITEM_ID     = 'item_id';
    const ORDER_ID    = 'order_id';
    const OPTION_ID   = 'option_id';
    const OPTION_QTY  = 'option_qty';
    const SELLER_ID   = 'seller_id';
    const STATUS      = 'status';
    const CREATED_AT  = 'created_at';
    const UPDATED_AT  = 'updated_at';

    /***/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id
     *
     * @return \Webkul\MarketplaceEventManager\Api\Data\MpeventInterface
     */
    public function setId($id);

    /**
     * @return string|null
     */
    public function getQrcode();

    /**
     * @param string $qrcode
     * @return $this
     */
    public function setQrcode($qrcode);

    /**
     * @return string|null
     */
    public function getItemId();

    /**
     * @param string $id
     * @return $this
     */
    public function setItemId($id);

    /**
     * @return string|null
     */
    public function getOrderId();

    /**
     * @param string $id
     * @return $this
     */
    public function setOrderId($id);

    /**
     * @return string|null
     */
    public function getOptionId();

    /**
     * @param string $id
     * @return $this
     */
    public function setOptionId($id);

    /**
     * @return string|null
     */
    public function getOptionQty();

    /**
     * @param string $qty
     * @return $this
     */
    public function setOptionQty($qty);

    /**
     * @return string|null
     */
    public function getSellerId();

    /**
     * @param string $id
     * @return $this
     */
    public function setSellerId($id);

    /**
     * @return string|null
     */
    public function getStatus();

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * @param datetime $createdat
     * @return $this
     */
    public function setCreatedAt($createdat);

    /**
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * @param datetime $updatedat
     * @return $this
     */
    public function setUpdatedAt($updatedat);
}
