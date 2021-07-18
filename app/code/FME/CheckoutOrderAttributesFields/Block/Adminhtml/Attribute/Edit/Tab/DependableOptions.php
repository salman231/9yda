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
use Magento\Customer\Controller\RegistryConstants;

class DependableOptions extends \Magento\Framework\View\Element\Template
{
	/**
     * @var \FME\CheckoutOrderAttributesFields\Helper\Attributes
     */
    private $helper;
    /**
     * @var \FME\CheckoutOrderAttributesFields\Helper\Data
     */
    private $dataHelper;
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;
	/**
     * Data constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context,
     * @param \FME\CheckoutOrderAttributesFields\Helper\Attributes $helper
     * @param \FME\CheckoutOrderAttributesFields\Helper\Data $dataHelper
     * @param \Magento\Framework\Registry $registry,
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \FME\CheckoutOrderAttributesFields\Helper\Attributes $helper,
        \FME\CheckoutOrderAttributesFields\Helper\Data $dataHelper,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->helper       = $helper;
        $this->dataHelper   = $dataHelper;
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    /**
     * get URL
     *
     * @param string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('checkoutorderattributesfields/attribute/options');
    }
}
