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

class Billing extends \Magento\Framework\View\Element\Template
{
    protected $resultJsonFactory;
    protected $datahelper;
    protected $_checkoutSession;
    protected $date;
    protected $timezone;
    /**
     * @param \Magento\Checkout\Model\Session             $checkoutSession
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Magento\Framework\Stdlib\DateTime\Timezone $timezone
     * @param JsonFactory                                 $resultJsonFactory
     * @param \FME\CheckoutOrderAttributesFields\Helper\Data $datahelper
     * @param Context                                     $context
     * @param array                                       $data
     */
    public function __construct(
    	\Magento\Checkout\Model\Session $checkoutSession,
    	\Magento\Framework\Stdlib\DateTime\DateTime $date,
    	\Magento\Framework\Stdlib\DateTime\Timezone $timezone,
    	JsonFactory $resultJsonFactory,
    	\FME\CheckoutOrderAttributesFields\Helper\Data $datahelper,
        Context $context,
        array $data = []
    ) {
    	$this->_checkoutSession = $checkoutSession;
    	$this->date = $date;
    	$this->resultJsonFactory = $resultJsonFactory;
    	$this->datahelper = $datahelper;
    	$this->timezone = $timezone;
        parent::__construct($context, $data);
    }
	/**
     * Get quote data from session
     *
     * @return string|array|int
     *
     */
    public function getQuoteData($value)
    {
        return $this->_checkoutSession->getQuote()->getData($value);
    }
    /**
     * Get current datetime
     *
     * @return string
     *
     */
    public function getCurrentDateTime()
    {
	   //date_default_timezone_set('Europe/London');
	   return date("Y-m-d H:i:s");
    }
    /**
     * Get current timestamp
     *
     * @return string
     *
     */
    public function getCurrentTimeStamp()
    {
        return  $this->date->gmtTimestamp();
    }
    /**
     * Get gmtoffset
     *
     * @return Object
     *
     */
    public function getCurrentTimeZoneOffset()
    {
        return  $this->date->getGmtOffset();
    }
    /**
     * Get timezone
     *
     * @return string
     *
     */
    public function getTimeZone()
    {
        return $this->timezone->getConfigTimezone();
    }
}
