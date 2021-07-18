<?php
namespace Magento\CatalogSearch\Model\Search\SelectContainer\SelectContainer;

/**
 * Interceptor class for @see \Magento\CatalogSearch\Model\Search\SelectContainer\SelectContainer
 */
class Interceptor extends \Magento\CatalogSearch\Model\Search\SelectContainer\SelectContainer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\DB\Select $select, array $nonCustomAttributesFilters, array $customAttributesFilters, array $dimensions, bool $isFullTextSearchRequired, bool $isShowOutOfStockEnabled, $usedIndex, ?\Magento\Framework\Search\Request\FilterInterface $visibilityFilter = null)
    {
        $this->___init();
        parent::__construct($select, $nonCustomAttributesFilters, $customAttributesFilters, $dimensions, $isFullTextSearchRequired, $isShowOutOfStockEnabled, $usedIndex, $visibilityFilter);
    }

    /**
     * {@inheritdoc}
     */
    public function updateSelect(\Magento\Framework\DB\Select $select)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'updateSelect');
        if (!$pluginInfo) {
            return parent::updateSelect($select);
        } else {
            return $this->___callPlugins('updateSelect', func_get_args(), $pluginInfo);
        }
    }
}
