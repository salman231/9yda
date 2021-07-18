<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Block\Adminhtml\Settings\Field\Elements;

/**
 * Class Textarea
 */
class Textarea extends \Magento\Framework\View\Element\AbstractBlock
{
    public function toHtml()
    {
        return '<textarea id="' . $this->getInputId() .
            '"' .
            ' name="' .
            $this->getInputName() .
            '"><%- ' . $this->getColumnName() .' %></textarea>';
    }
}
