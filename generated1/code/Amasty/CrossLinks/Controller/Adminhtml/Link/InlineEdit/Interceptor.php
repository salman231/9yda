<?php
namespace Amasty\CrossLinks\Controller\Adminhtml\Link\InlineEdit;

/**
 * Interceptor class for @see \Amasty\CrossLinks\Controller\Adminhtml\Link\InlineEdit
 */
class Interceptor extends \Amasty\CrossLinks\Controller\Adminhtml\Link\InlineEdit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Amasty\CrossLinks\Model\LinkFactory $linkFactory, \Amasty\CrossLinks\Api\LinkRepositoryInterface $linkRepository, \Magento\Backend\Model\SessionFactory $sessionFactory, \Magento\Framework\App\Cache\TypeListInterface $typeList, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $resultPageFactory, $linkFactory, $linkRepository, $sessionFactory, $typeList, $resultForwardFactory, $jsonFactory);
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
