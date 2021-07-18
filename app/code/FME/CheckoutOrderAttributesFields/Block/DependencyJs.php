<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */

namespace FME\CheckoutOrderAttributesFields\Block;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Controller\Result\JsonFactory;
class DependencyJs extends \Magento\Framework\View\Element\Template
{
    protected $resultJsonFactory;
    protected $datahelper;
    protected $checkoutSession;
    protected $attributehelper;
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \FME\CheckoutOrderAttributesFields\Helper\Data $datahelper,
        \FME\CheckoutOrderAttributesFields\Helper\Attributes $attributehelper,
        Context $context,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->datahelper = $datahelper;
        $this->attributehelper = $attributehelper;
        parent::__construct($context, $data);
    }
    
    /**
     * Get list of used Attributes.
     *
     * @return Object
     *
     */
    public function getAvailableAttributes()
    {
        return $this->attributehelper->getStepAttributes();
    }
}
