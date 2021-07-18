<?php
namespace Webkul\Marketplace\Controller\Adminhtml\Feedback\Index;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Adminhtml\Feedback\Index
 */
class Interceptor extends \Webkul\Marketplace\Controller\Adminhtml\Feedback\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\Marketplace\Model\FeedbackFactory $feedbackModel)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $feedbackModel);
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
