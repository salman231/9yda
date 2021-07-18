<?php
namespace Webkul\Marketplace\Controller\Seller\Newfeedback;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Seller\Newfeedback
 */
class Interceptor extends \Webkul\Marketplace\Controller\Seller\Newfeedback implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Webkul\Marketplace\Helper\Data $helper, \Webkul\Marketplace\Model\FeedbackcountFactory $feedbackcountModel, \Webkul\Marketplace\Model\FeedbackFactory $feedbackFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $formKeyValidator, $date, $helper, $feedbackcountModel, $feedbackFactory);
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
