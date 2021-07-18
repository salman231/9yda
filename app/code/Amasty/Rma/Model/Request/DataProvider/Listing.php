<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Model\Request\DataProvider;

use Amasty\Rma\Api\Data\RequestInterface;
use Amasty\Rma\Api\Data\StatusInterface;
use Amasty\Rma\Model\OptionSource\Grid;
use Amasty\Rma\Model\Request\ResourceModel\CollectionFactory;
use Amasty\Rma\Model\Status\ResourceModel\CollectionFactory as StatusCollectionFactory;
use Magento\Framework\App\RequestInterface as AppRequest;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Backend\Model\Session;

/**
 * Class Listing
 */
class Listing extends AbstractDataProvider
{
    /**
     * @var array
     */
    public $statusColor;

    /**
     * @var Session
     */
    private $session;

    public function __construct(
        CollectionFactory $collectionFactory,
        AppRequest $request,
        StatusCollectionFactory $statusCollectionFactory,
        Session $session,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $statusIds = [];
        $statusCollection = $statusCollectionFactory->create();
        $statusCollection->addFieldToSelect(StatusInterface::STATUS_ID)
            ->addFieldToSelect(StatusInterface::COLOR);
        switch ($request->getParam('grid', 'pending')) {
            case 'pending':
                $statusCollection->addFieldToFilter(StatusInterface::GRID, Grid::PENDING);
                break;
            case 'archive':
                $statusCollection->addFieldToFilter(StatusInterface::GRID, Grid::ARCHIVED);
                break;
            case 'manage':
                $statusCollection->addFieldToFilter(StatusInterface::GRID, Grid::MANAGE);
                break;
            case 'order_view':
                $orderId = (int) $request->getParam(RequestInterface::ORDER_ID);
                $this->collection->addFieldToFilter(RequestInterface::ORDER_ID, $orderId);
                break;
        }
        foreach ($statusCollection->getData() as $status) {
            $statusIds[] = (int)$status[StatusInterface::STATUS_ID];
            $this->statusColor[$status[StatusInterface::STATUS_ID]] = $status[StatusInterface::COLOR];
        }

        //TODO
        if (empty($statusIds)) {
            $statusIds[] = 9999999999999;
        }

        $this->collection->addFieldToFilter('main_table.' . RequestInterface::STATUS, ['in' => $statusIds]);
        //TODO split database
        $this->collection->join(
            'sales_order',
            'main_table.' . RequestInterface::ORDER_ID . ' = sales_order.entity_id',
            [
                'sales_order.increment_id',
            ]
        )->join(
            ['st' => $this->collection->getTable(\Amasty\Rma\Model\Status\ResourceModel\Status::TABLE_NAME)],
            'main_table.' . RequestInterface::STATUS . ' = st.' . StatusInterface::STATUS_ID,
            [
                'st.' . StatusInterface::STATE
            ]
        );

        $data['config']['params']['order_id'] = $request->getParam(RequestInterface::ORDER_ID);

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->session = $session;
        $this->session->setAmRmaReturnUrl(null);
        $this->session->setAmRmaOriginalGrid(null);
    }

    /**
     * @inheritdoc
     */
    public function addFilter(\Magento\Framework\Api\Filter  $filter)
    {
        if ($filter->getField() == RequestInterface::STATUS) {
            $filter->setField('main_table.' . RequestInterface::STATUS);
        }

        parent::addFilter($filter);
    }

    public function getData()
    {
        $data = parent::getData();
        foreach ($data['items'] as &$item) {
            $item['increment_id'] = '#' . $item['increment_id'];
            $item['status_color'] = $this->statusColor[$item[RequestInterface::STATUS]];
            if ($item[RequestInterface::RATING] > 0) {
                $item['rating'] = $item[RequestInterface::RATING] . '/5';
            } else {
                $item['rating'] = '';
            }
        }

        return $data;
    }
}
