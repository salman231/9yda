<?php

namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Attribute;


abstract class Product extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Namespace_Module::item_list';


}
