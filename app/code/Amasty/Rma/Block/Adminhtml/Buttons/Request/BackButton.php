<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Rma
 */


namespace Amasty\Rma\Block\Adminhtml\Buttons\Request;

use Amasty\Rma\Block\Adminhtml\Buttons\GenericButton;
use Amasty\Rma\Controller\Adminhtml\RegistryConstants;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;

    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $session;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\App\Response\RedirectInterface $redirect
    ) {
        parent::__construct($context);
        $this->session = $context->getBackendSession();
        $this->redirect = $redirect;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $onClick = sprintf("location.href = '%s'", $this->getBackUrl());

        $data = [
            'label' => __('Back'),
            'class' => 'action- scalable back',
            'id' => 'back',
            'on_click' => $onClick,
            'sort_order' => 20,
        ];

        return $data;
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        $returnUrl = $this->session->getAmRmaReturnUrl();

        if (!$returnUrl) {
            $returnUrl = $this->redirect->getRefererUrl();
            $this->session->setAmRmaReturnUrl($returnUrl);
        }

        return $returnUrl;
    }

    /**
     * @return null|int
     */
    public function getRequestId()
    {
        return (int)$this->request->getParam(RegistryConstants::REQUEST_ID);
    }
}
