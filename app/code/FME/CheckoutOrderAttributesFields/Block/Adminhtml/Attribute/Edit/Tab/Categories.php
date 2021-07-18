<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */

namespace FME\CheckoutOrderAttributesFields\Block\Adminhtml\Attribute\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Categories extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    protected $_systemStore;
    protected $_groupRepository;
    protected $_searchCriteriaBuilder;
    protected $_objectConverter;
    protected $_categoryHelper;
    protected $_categorylist;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $registry
     * @param Store systemStore
     * @param FormFactory $formFactory
     * @param GroupRepositoryInterface $groupRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder,
     * @param DataObject $objectConverter,
     * @param Categorydata $categorylist,
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \Magento\Store\Model\System\Store $systemStore,
        FormFactory $formFactory,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Convert\DataObject $objectConverter,
        \FME\CheckoutOrderAttributesFields\Block\Adminhtml\Attribute\Edit\Tab\Categorydata $categorylist,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_groupRepository = $groupRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_objectConverter = $objectConverter;
        $this->_categorylist = $categorylist;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return Generic
     */
    protected function _prepareForm()
    {
      /* @var $model \FME\Restrictcustomergroup\Model\Rule */
        $model = $this->_coreRegistry->registry('entity_attribute');

        $isElementDisabled = false;

        /** @var \Magento\Framework\Data\Form $form */
        //$form = $this->_formFactory->create();
        $form = $this->_formFactory->create(
            [
                'data' => [
                   'id' => 'edit_form',
                   'action' => $this->getData('action'),
                   'method' => 'post',
                   'enctype' => 'multipart/form-data'
               ]
           ]);

          $form->setHtmlIdPrefix('rule_');


        $fieldset = $form->addFieldset('categories_fieldset', array(
            'legend'    => __('Select Categories'),
            'class'     => 'fieldset-wide',
        ));

        if(!empty($model)){
            if ($model->getId()) {
                $fieldset->addField('category_id', 'hidden', ['name' => 'category_id']);
            }
        }

        $field = $fieldset->addField(
            'categories_ids',
            'multiselect',
            [
                'name' => 'categories_ids',
                'label' => __('Categories'),
                'title' => __('Categories'),
                'elementTmpl' =>__('ui/grid/filters/elements/ui-select'),
                'component' =>__('Magento_Catalog/js/components/new-category'),
                'required' => false,
                'values' => $this->_categorylist->toOptionArray(),
                'disabled' => $isElementDisabled
            ]
        );

        if(!empty($model)){
            $form->setValues($model->getData());
            if ($form) {

            }
        }
        $this->setForm($form);

        //  $this->_eventManager->dispatch('adminhtml_rule_edit_tab_categories_prepare_form', ['form' => $form]);

        return parent::_prepareForm();
    }


    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Categories');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Categories');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

}
