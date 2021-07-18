<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Observer;

/**
 * Class RmaEventNames
 */
class RmaEventNames
{
    //Customer Events
    const STATUS_CHANGED = 'amasty_rma_status_changed';
    const NEW_CHAT_MESSAGE = 'amasty_customer_rma_new_message';
    const BEFORE_CREATE_RMA = 'amasty_customer_rma_before_create';
    const RMA_CREATED = 'amasty_customer_rma_created';
    const RMA_RATED = 'amasty_customer_rated_rma';
    const TRACKING_NUBMER_ADDED = 'amasty_customer_added_tracking_number_rma';
    const RMA_CANCELED = 'amasty_customer_rma_canceled';
}
