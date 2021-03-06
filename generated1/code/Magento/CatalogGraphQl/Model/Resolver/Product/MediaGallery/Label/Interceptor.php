<?php
namespace Magento\CatalogGraphQl\Model\Resolver\Product\MediaGallery\Label;

/**
 * Interceptor class for @see \Magento\CatalogGraphQl\Model\Resolver\Product\MediaGallery\Label
 */
class Interceptor extends \Magento\CatalogGraphQl\Model\Resolver\Product\MediaGallery\Label implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ResourceModel\Product $productResource)
    {
        $this->___init();
        parent::__construct($productResource);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(\Magento\Framework\GraphQl\Config\Element\Field $field, $context, \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info, ?array $value = null, ?array $args = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        if (!$pluginInfo) {
            return parent::resolve($field, $context, $info, $value, $args);
        } else {
            return $this->___callPlugins('resolve', func_get_args(), $pluginInfo);
        }
    }
}
