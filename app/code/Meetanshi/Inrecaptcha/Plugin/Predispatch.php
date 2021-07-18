<?php

namespace Meetanshi\Inrecaptcha\Plugin;

use Magento\Framework\UrlInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\ResponseFactory;
use Meetanshi\Inrecaptcha\Helper\Data;
use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Class Predispatch
 * @package Meetanshi\Inrecaptcha\Plugin
 */
class Predispatch
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var RedirectInterface
     */
    private $redirect;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var Data
     */
    private $helper;

    /**
     * Predispatch constructor.
     * @param UrlInterface $urlBuilder
     * @param ManagerInterface $messageManager
     * @param RedirectInterface $redirect
     * @param ResponseFactory $responseFactory
     * @param Data $helper
     */
    public function __construct(UrlInterface $urlBuilder, ManagerInterface $messageManager, RedirectInterface $redirect, ResponseFactory $responseFactory, Data $helper)
    {
        $this->urlBuilder = $urlBuilder;
        $this->messageManager = $messageManager;
        $this->redirect = $redirect;
        $this->responseFactory = $responseFactory;
        $this->helper = $helper;
    }

    /**
     * @param FrontControllerInterface $subject
     * @param \Closure $proceed
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface|mixed
     */
    public function aroundDispatch(FrontControllerInterface $subject, \Closure $proceed, RequestInterface $request)
    {
        if ($this->helper->isEnabled()) {
            foreach ($this->helper->getSelectorsUrls() as $url) {
                if ($request->isPost()
                    && false !== strpos($this->urlBuilder->getCurrentUrl(), $url)
                ) {
                    $token = $request->getPost('invisible_token');
                    $validation = $this->helper->validate($token);
                    if (!$validation['success']) {
                        $this->messageManager->addErrorMessage($validation['error']);
                        $response = $this->responseFactory->create();
                        $response->setRedirect($this->redirect->getRefererUrl());
                        $response->setNoCacheHeaders();
                        return $response;
                    }
                    break;
                }
            }
        }
        $result = $proceed($request);

        return $result;
    }
}
