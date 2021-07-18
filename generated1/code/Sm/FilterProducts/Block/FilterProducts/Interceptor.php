<?php
namespace Sm\FilterProducts\Block\FilterProducts;

/**
 * Interceptor class for @see \Sm\FilterProducts\Block\FilterProducts
 */
class Interceptor extends \Sm\FilterProducts\Block\FilterProducts implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Catalog\Model\ResourceModel\Product\Collection $collection, \Magento\Framework\App\ResourceConnection $resource, \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility, \Magento\Catalog\Block\Product\Context $context, array $data = [], $attr = null)
    {
        $this->___init();
        parent::__construct($objectManager, $collection, $resource, $catalogProductVisibility, $context, $data, $attr);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        if (!$pluginInfo) {
            return parent::getImage($product, $imageId, $attributes);
        } else {
            return $this->___callPlugins('getImage', func_get_args(), $pluginInfo);
        }
    }
}
