<?php
namespace Magento\InventorySales\Model\IsProductSalableForRequestedQtyCondition\IsCorrectQtyCondition;

/**
 * Interceptor class for @see \Magento\InventorySales\Model\IsProductSalableForRequestedQtyCondition\IsCorrectQtyCondition
 */
class Interceptor extends \Magento\InventorySales\Model\IsProductSalableForRequestedQtyCondition\IsCorrectQtyCondition implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\InventoryConfigurationApi\Api\GetStockItemConfigurationInterface $getStockItemConfiguration, \Magento\CatalogInventory\Api\StockConfigurationInterface $configuration, \Magento\InventoryReservationsApi\Model\GetReservationsQuantityInterface $getReservationsQuantity, \Magento\InventorySalesApi\Model\GetStockItemDataInterface $getStockItemData, \Magento\Framework\Math\Division $mathDivision, \Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory, \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory $productSalableResultFactory)
    {
        $this->___init();
        parent::__construct($getStockItemConfiguration, $configuration, $getReservationsQuantity, $getStockItemData, $mathDivision, $productSalabilityErrorFactory, $productSalableResultFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(string $sku, int $stockId, float $requestedQty) : \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterface
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute($sku, $stockId, $requestedQty);
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }
}
