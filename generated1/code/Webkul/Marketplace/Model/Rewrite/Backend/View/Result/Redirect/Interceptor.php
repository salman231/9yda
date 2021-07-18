<?php
namespace Webkul\Marketplace\Model\Rewrite\Backend\View\Result\Redirect;

/**
 * Interceptor class for @see \Webkul\Marketplace\Model\Rewrite\Backend\View\Result\Redirect
 */
class Interceptor extends \Webkul\Marketplace\Model\Rewrite\Backend\View\Result\Redirect implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Response\RedirectInterface $redirect, \Magento\Backend\Model\UrlInterface $urlBuilder, \Magento\Backend\Model\Session $session, \Magento\Framework\App\ActionFlag $actionFlag)
    {
        $this->___init();
        parent::__construct($redirect, $urlBuilder, $session, $actionFlag);
    }

    /**
     * {@inheritdoc}
     */
    public function renderResult(\Magento\Framework\App\ResponseInterface $response)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'renderResult');
        if (!$pluginInfo) {
            return parent::renderResult($response);
        } else {
            return $this->___callPlugins('renderResult', func_get_args(), $pluginInfo);
        }
    }
}
