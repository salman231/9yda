<?php
/**
 * Webkul MarketplaceEventManager CatalogProductSaveBefore Observer.
 * @category  Webkul
 * @package   Webkul_MarketplaceEventManager
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MarketplaceEventManager\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CatalogProductSaveBefore implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $localeDate;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param TimezoneInterface $localeDate,
     * @param ProductRepositoryInterface $productRepository,
     * @param RequestInterface $request,
     * @param ScopeConfigInterface $scopeInterface
     */
    public function __construct(
        TimezoneInterface $localeDate,
        ProductRepositoryInterface $productRepository,
        RequestInterface $request,
        ScopeConfigInterface $scopeInterface
    ) {
        $this->localeDate = $localeDate;
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->scopeConfig = $scopeInterface;
    }

    /**
     * product save event handler.
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $productData = $this->request->getParam('product');
        $type = $this->request->getParam('type');
        if ($type == 'etickets') {
            $configTimeZone = $this->localeDate->getConfigTimezone();
            $defaultTimeZone = $this->localeDate->getDefaultTimezone();
            $eventStartDate = $productData['event_start_date_tmp'];
            $eventEndDate = $productData['event_end_date_tmp'];
            if ($eventStartDate != '') {
                $product->setEventStartDate($eventStartDate);
            }
            if ($eventEndDate != '') {
                $product->setEventEndDate($eventEndDate);
            }
            $product->setIsMpEvent(1);
        }
        return $this;
    }
}
