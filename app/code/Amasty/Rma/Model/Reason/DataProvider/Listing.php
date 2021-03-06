<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\Reason\DataProvider;

use Amasty\Rma\Api\Data\ReasonInterface;
use Amasty\Rma\Model\Reason\ResourceModel\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class Listing
 */
class Listing extends AbstractDataProvider
{
    public function __construct(
        CollectionFactory $collectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->collection->addFieldToFilter(ReasonInterface::IS_DELETED, 0);

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
}
