<?php
namespace Magento\Quote\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Quote\Api\Data\TotalSegmentInterface
 */
interface TotalSegmentExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return \Magento\Tax\Api\Data\GrandTotalDetailsInterface[]|null
     */
    public function getTaxGrandtotalDetails();

    /**
     * @param \Magento\Tax\Api\Data\GrandTotalDetailsInterface[] $taxGrandtotalDetails
     * @return $this
     */
    public function setTaxGrandtotalDetails($taxGrandtotalDetails);

    /**
     * @return float|null
     */
    public function getGiftWrapAmount();

    /**
     * @param float $giftWrapAmount
     * @return $this
     */
    public function setGiftWrapAmount($giftWrapAmount);

    /**
     * @return string[]|null
     */
    public function getVertexTaxCalculationMessages();

    /**
     * @param string[] $vertexTaxCalculationMessages
     * @return $this
     */
    public function setVertexTaxCalculationMessages($vertexTaxCalculationMessages);
}
