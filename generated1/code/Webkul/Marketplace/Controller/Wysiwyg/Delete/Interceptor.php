<?php
namespace Webkul\Marketplace\Controller\Wysiwyg\Delete;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Wysiwyg\Delete
 */
class Interceptor extends \Webkul\Marketplace\Controller\Wysiwyg\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory, \Webkul\Marketplace\Api\Data\WysiwygImageInterfaceFactory $wysiwygImage, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\Marketplace\Helper\Data $mpHelper)
    {
        $this->___init();
        parent::__construct($context, $jsonResultFactory, $wysiwygImage, $resultPageFactory, $mpHelper);
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
