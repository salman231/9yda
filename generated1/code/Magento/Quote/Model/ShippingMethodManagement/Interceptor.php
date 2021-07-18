<?php
namespace Magento\Quote\Model\ShippingMethodManagement;

/**
 * Interceptor class for @see \Magento\Quote\Model\ShippingMethodManagement
 */
class Interceptor extends \Magento\Quote\Model\ShippingMethodManagement implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Quote\Api\CartRepositoryInterface $quoteRepository, \Magento\Quote\Model\Cart\ShippingMethodConverter $converter, \Magento\Customer\Api\AddressRepositoryInterface $addressRepository, \Magento\Quote\Model\Quote\TotalsCollector $totalsCollector, ?\Magento\Customer\Api\Data\AddressInterfaceFactory $addressFactory = null, ?\Magento\Quote\Model\ResourceModel\Quote\Address $quoteAddressResource = null)
    {
        $this->___init();
        parent::__construct($quoteRepository, $converter, $addressRepository, $totalsCollector, $addressFactory, $quoteAddressResource);
    }

    /**
     * {@inheritdoc}
     */
    public function estimateByAddress($cartId, \Magento\Quote\Api\Data\EstimateAddressInterface $address)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'estimateByAddress');
        if (!$pluginInfo) {
            return parent::estimateByAddress($cartId, $address);
        } else {
            return $this->___callPlugins('estimateByAddress', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function estimateByExtendedAddress($cartId, \Magento\Quote\Api\Data\AddressInterface $address)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'estimateByExtendedAddress');
        if (!$pluginInfo) {
            return parent::estimateByExtendedAddress($cartId, $address);
        } else {
            return $this->___callPlugins('estimateByExtendedAddress', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function estimateByAddressId($cartId, $addressId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'estimateByAddressId');
        if (!$pluginInfo) {
            return parent::estimateByAddressId($cartId, $addressId);
        } else {
            return $this->___callPlugins('estimateByAddressId', func_get_args(), $pluginInfo);
        }
    }
}
