<?php
namespace Webkul\Marketplace\Controller\Mui\Export\GridToXml;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Mui\Export\GridToXml
 */
class Interceptor extends \Webkul\Marketplace\Controller\Mui\Export\GridToXml implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Ui\Model\Export\ConvertToXml $convertToXml, \Magento\Framework\App\Response\Http\FileFactory $httpFile)
    {
        $this->___init();
        parent::__construct($context, $convertToXml, $httpFile);
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
