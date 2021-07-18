<?php
namespace Temando\Shipping\Controller\Adminhtml\Order\View;

/**
 * Interceptor class for @see \Temando\Shipping\Controller\Adminhtml\Order\View
 */
class Interceptor extends \Temando\Shipping\Controller\Adminhtml\Order\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Temando\Shipping\Model\ResourceModel\Repository\ShipmentReferenceRepositoryInterface $shipmentReferenceRepository, \Magento\Framework\Api\Search\SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory, \Magento\Framework\Api\FilterBuilder $filterBuilder, \Magento\Framework\Escaper $escaper)
    {
        $this->___init();
        parent::__construct($context, $shipmentReferenceRepository, $searchCriteriaBuilderFactory, $filterBuilder, $escaper);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
