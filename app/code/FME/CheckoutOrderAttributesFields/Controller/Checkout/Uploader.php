<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Controller\Checkout;

use Magento\Contact\Model\ConfigInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\PageFactory;

class Uploader extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;
    
    /**
     * @var \FME\CheckoutOrderAttributesFields\Helper\Data
     */
    private $helper;
    /**
     * @var jsonHelper
     */

    private $jsonHelper;
    /**
     * Image uploader
     *
     * @var \Magento\Catalog\Model\ImageUploader
     */
    private $imageUploader;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        \FME\CheckoutOrderAttributesFields\Helper\Data $helper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \FME\CheckoutOrderAttributesFields\Model\ImageUploader $imageUploader
    ) {
        $this->imageUploader = $imageUploader;
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->helper          = $helper;
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context);
    }//end __construct()
    
    /**
     * Dispatch request
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->helper->getStatus()) {
            throw new NotFoundException(__('Page disabled found.'));
        }
        return parent::dispatch($request);
    }
    /**
     * Customer order history
     *
     * @return \Magento\Framework\View\Result\Page $resultPage
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        try {
            $response = $this->imageUploader->saveFileToTmpDir($data['param_name']);
            return $this->getResponse()->representJson(
                $this->jsonHelper->jsonEncode($response)
            );
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $error = true;
            $response = ['message'=>$e->getMessage(),'error'=>$e->getMessage(),'success'=> ($error) ? false : true ];
            return $this->getResponse()->representJson(
                $this->jsonHelper->jsonEncode($response)
            );
        } catch (\Exception $e) {
            $error = true;
            $response = ['message'=>$e->getMessage(),'error'=>$e->getMessage(),'success'=> ($error) ? false : true ];
            return $this->getResponse()->representJson(
                $this->jsonHelper->jsonEncode($response)
            );
        }
    }
}//end class
