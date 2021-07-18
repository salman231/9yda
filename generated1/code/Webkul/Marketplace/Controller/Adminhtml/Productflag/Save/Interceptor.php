<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Productflag\Save;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Productflag\Save
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Productflag\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Webkul\Marketplace\Model\ProductFlagReasonFactory $productFlagReasonFactory, \Webkul\Marketplace\Api\ProductFlagReasonRepositoryInterface $productFlagReasonRepository, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor)
    {
        $this->___init();
        parent::__construct($context, $productFlagReasonFactory, $productFlagReasonRepository, $date, $dataPersistor);
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
