<?php
namespace FME\CheckoutOrderAttributesFields\Block\Adminhtml\Attribute\Edit\Tab;
use Magento\Framework\Data\OptionSourceInterface;
class Categorydata implements OptionSourceInterface
{

    /**
     * @var \FME\SeoMetaTagsGenerator\Model\Metatemplate
     */
    protected $_categoryHelper;
    protected $categoryFlatConfig;
    /**
     * Constructor
     *
     * @param \FME\SeoMetaTagsGenerator\Model\Metatemplate $_seometatagsgeneratorgroupRule
     */
    public function __construct( \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState)
    {
        $this->_categoryHelper = $categoryHelper;
        $this->categoryFlatConfig = $categoryFlatState;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {


        $options = [];
        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();

        $categoryCollection = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
        $categories = $categoryCollection->create();
        $categories->addAttributeToSelect('*');

        foreach ($categories as $category) {
            $options[] = [
                        'label' => str_repeat("--- ",$category->getLevel()).$category->getName(),
                        'value' => $category->getId(),
                    ];
        }

        unset($options[0]);

        return $options;
    }

}
