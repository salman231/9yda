<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;

class ConfigProvider implements ConfigProviderInterface
{
    /** @var LayoutInterface  */
    private $layout;
    
    /** @var Quote  */
    private $quote;
    private $attrHelper;
    protected $blockFactory;
    /**
     * @var \FME\CheckoutOrderAttributesFields\Helper\Data
     */
    private $helper;
    /**
     * Initialize constructor
     *
     * @param LayoutInterface $layout
     * @param  \Magento\Checkout\Model\Session $checkoutSession
     * @param  \FME\CheckoutOrderAttributesFields\Helper\Data $helper
     * @param  \Magento\Framework\View\Element\BlockFactory $blockFactory
     * @param  \FME\CheckoutOrderAttributesFields\Helper\Attributes $attrHelper
     */
    public function __construct(
        LayoutInterface $layout,
        \Magento\Checkout\Model\Session $checkoutSession,
        \FME\CheckoutOrderAttributesFields\Helper\Data $helper,
        \Magento\Framework\View\Element\BlockFactory $blockFactory,
        \FME\CheckoutOrderAttributesFields\Helper\Attributes $attrHelper
    ) {
        $this->quote  = $checkoutSession->getQuote();
        $this->layout = $layout;
        $this->helper  = $helper;
        $this->attrHelper = $attrHelper;
        $this->blockFactory = $blockFactory;
    }
    /**
     * get config values
     *
     * @return array
     */
    public function getConfig()
    {
        $scripts = $this->getAttributesScripts();
        return [
            'checkoutorderattributesfieldsheading' => $this->helper->getHeading(),
            'dependency' => $scripts
        ];
    }
    /**
     * get attribute Js scripts
     *
     * @return string
     */
    private function getAttributesScripts(){
        $attributes = $this->attrHelper->getStepAttributes();
        $block = $this->blockFactory->createBlock("\Magento\Framework\View\Element\Template")
            ->setName("dependable.attributes.scripts")
            ->setAvailableAttributes($attributes)
            ->setHelper($this->attrHelper)
            ->setTemplate('FME_CheckoutOrderAttributesFields::fields.phtml')->toHtml();
        return $block;
    }
}
