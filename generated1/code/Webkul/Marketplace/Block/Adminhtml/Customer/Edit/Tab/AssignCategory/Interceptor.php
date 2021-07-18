<?php
namespace Webkul\Marketplace\Block\Adminhtml\Customer\Edit\Tab\AssignCategory;

/**
 * Interceptor class for @see \Webkul\Marketplace\Block\Adminhtml\Customer\Edit\Tab\AssignCategory
 */
class Interceptor extends \Webkul\Marketplace\Block\Adminhtml\Customer\Edit\Tab\AssignCategory implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Widget\Context $context, \Magento\Framework\Registry $registry, \Magento\Catalog\Model\Category $category, \Magento\Catalog\Helper\Category $categoryHelper, \Webkul\Marketplace\Model\SellerFactory $sellerFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $category, $categoryHelper, $sellerFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        if (!$pluginInfo) {
            return parent::render($element);
        } else {
            return $this->___callPlugins('render', func_get_args(), $pluginInfo);
        }
    }
}
