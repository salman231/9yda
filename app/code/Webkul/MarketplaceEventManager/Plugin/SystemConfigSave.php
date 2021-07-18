<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MarketplaceEventManager
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MarketplaceEventManager\Plugin;

class SystemConfigSave
{
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Backend\Model\View\Result\Redirect $redirect,
        \Magento\Framework\App\Response\RedirectInterface $redirectInterface,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Framework\Webapi\Rest\Request $request
    ) {
        $this->messageManager = $messageManager;
        $this->redirect = $redirect;
        $this->redirectInterface = $redirectInterface;
        $this->_request = $request;
        $this->resultFactory = $resultFactory;
    }

    public function aroundExecute(
        \Magento\Config\Controller\Adminhtml\System\Config\Save $subject,
        \Closure $proceed,
        $requestInfo = null
    ) {
        $data = $this->_request->getParams();
        $msg = "";
        if (isset($data['groups']['settings']['fields']['from_date']['value']) && isset($data['groups']['settings']['fields']['to_date']['value'])) {
            $eventStartDate = $data['groups']['settings']['fields']['from_date']['value'];
            $eventEndDate = $data['groups']['settings']['fields']['to_date']['value'];
            if ($eventStartDate && $eventEndDate) {
                if (strtotime($eventStartDate)<0 || strtotime($eventEndDate)<0) {
                    $msg = __("Event Dates must be valid.");
                } elseif (strtotime($eventStartDate) >= strtotime($eventEndDate)) {
                    $msg = __("You can not select previous date from Event Start Date as Event End Date.");
                }
            }
        }
        if (!$msg) {
            $result = $proceed($requestInfo);
            return $result;
        } else {
            $redirectUrl = $this->redirectInterface->getRefererUrl();
            $this->messageManager->addError($msg);
            $resultRedirect = $this->resultFactory->create(
                \Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT
            );
            $result = $resultRedirect->setUrl($redirectUrl);
            return $result;
        }
    }
}
