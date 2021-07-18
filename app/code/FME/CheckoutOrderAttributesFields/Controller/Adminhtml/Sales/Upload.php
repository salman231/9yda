<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */

// @codingStandardsIgnoreFile

namespace FME\CheckoutOrderAttributesFields\Controller\Adminhtml\Sales;

use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Upload extends \Magento\Backend\App\Action
{
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
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \FME\CheckoutOrderAttributesFields\Model\ImageUploader $imageUploader
    ) {
        $this->imageUploader = $imageUploader;
        $this->helper        = $helper;
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
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
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
            $response = ['message'=>$e->getMessage(),'error'=>$error,'success'=> ($error) ? false : true ];
            return $this->getResponse()->representJson(
                $this->jsonHelper->jsonEncode($response)
            );
        } catch (\Exception $e) {
            $error = true;
            $response = ['message'=>$e->getMessage(),'error'=>$error,'success'=> ($error) ? false : true ];
            return $this->getResponse()->representJson(
                $this->jsonHelper->jsonEncode($response)
            );
        }
    }

    /**
     * Determine if authorized to perform group actions.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
