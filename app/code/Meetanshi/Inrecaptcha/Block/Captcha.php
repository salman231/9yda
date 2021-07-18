<?php

namespace Meetanshi\Inrecaptcha\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Meetanshi\Inrecaptcha\Helper\Data;

/**
 * Class Captcha
 * @package Meetanshi\Inrecaptcha\Block
 */
class Captcha extends Template
{
    /**
     * @var
     */
    protected $objectManager;
    /**
     * @var Data
     */
    private $helper;

    /**
     * Captcha constructor.
     * @param Context $context
     * @param Data $helper
     * @param array $data
     */
    public function __construct(Context $context, Data $helper, array $data = [])
    {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * @return Data
     */
    public function getCaptcha()
    {
        return $this->helper;
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        if (!$this->getCaptcha()->isEnabled()) {
            return '';
        }
        return parent::toHtml();
    }
}
