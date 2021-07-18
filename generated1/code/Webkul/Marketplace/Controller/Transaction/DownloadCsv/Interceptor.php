<?php
namespace Webkul\Marketplace\Controller\Transaction\DownloadCsv;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Transaction\DownloadCsv
 */
class Interceptor extends \Webkul\Marketplace\Controller\Transaction\DownloadCsv implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Model\Url $customerUrl, \Webkul\Marketplace\Model\SellertransactionFactory $sellertransactionFactory, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $customerUrl, $sellertransactionFactory, $logger);
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
