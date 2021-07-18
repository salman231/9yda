<?php
namespace Webkul\Marketplace\Controller\Account\EditprofilePost;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Account\EditprofilePost
 */
class Interceptor extends \Webkul\Marketplace\Controller\Account\EditprofilePost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\Filesystem $filesystem, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Webkul\Marketplace\Helper\Data $helper, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \Magento\Customer\Model\Url $customerUrl, \Webkul\Marketplace\Model\SellerFactory $sellerModel, \Magento\Customer\Model\CustomerFactory $customerModel)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $formKeyValidator, $date, $filesystem, $fileUploaderFactory, $helper, $dataPersistor, $customerUrl, $sellerModel, $customerModel);
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
