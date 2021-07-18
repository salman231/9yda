<?php

namespace Meetanshi\Inrecaptcha\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\HTTP\Client\Curl;

/**
 * Class Data
 * @package Meetanshi\Inrecaptcha\Helper
 */
class Data extends AbstractHelper
{
    /**
     *
     */
    const GOOGLE_SITE_VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';
    const CONFIG_PATH_IS_ENABLE = 'inrecaptcha/general/enable';
    const CONFIG_PATH_SITE_KEY = 'inrecaptcha/general/sitekey';
    const CONFIG_PATH_SECRET_KEY = 'inrecaptcha/general/sitesecret';
    const CONFIG_PATH_URLS = 'inrecaptcha/general/urls';
    const CONFIG_PATH_SELECTORS = 'inrecaptcha/general/selectors';

    /**
     * @var Curl
     */
    protected $curl;

    /**
     * Data constructor.
     * @param Context $context
     * @param Curl $curl
     */
    public function __construct(Context $context, Curl $curl)
    {
        $this->curl = $curl;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(self::CONFIG_PATH_IS_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getSiteKey()
    {
        return $this->scopeConfig->getValue(self::CONFIG_PATH_SITE_KEY, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getSelectorsJson()
    {
        $selectors = trim($this->scopeConfig->getValue(self::CONFIG_PATH_SELECTORS, ScopeInterface::SCOPE_STORE));

        $selectors = $selectors ? $this->stringValidationAndConvertToArray($selectors) : [];

        return \Zend_Json::encode($selectors);
    }

    /**
     * @param $string
     * @return array|false|string[]
     */
    public function stringValidationAndConvertToArray($string)
    {
        $validate = function ($urls) {
            return preg_split('|\s*[\r\n]+\s*|', $urls, -1, PREG_SPLIT_NO_EMPTY);
        };

        return $validate($string);
    }

    /**
     * @return array|false|string|string[]
     */
    public function getSelectorsUrls()
    {
        $urls = trim($this->scopeConfig->getValue(self::CONFIG_PATH_URLS, ScopeInterface::SCOPE_STORE));

        $urls = $urls ? $this->stringValidationAndConvertToArray($urls) : [];

        return $urls;
    }

    /**
     * @param $token
     * @return array
     */
    public function validate($token)
    {
        $verification = [
            'success' => false,
            'error' => 'The request is invalid or malformed.'
        ];
        if ($token) {
            try {
                $secret = $this->scopeConfig->getValue(self::CONFIG_PATH_SECRET_KEY, ScopeInterface::SCOPE_STORE);
                $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' .
                    $secret . '&response=' . $token . '&remoteip=' . $_SERVER["REMOTE_ADDR"];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($ch);

                $result = json_decode($response, true);

                if ($result['success']) {
                    $verification['success'] = true;
                } elseif (array_key_exists('error-codes', $result)) {
                    $verification['error'] = $this->getErrorMessage($result['error-codes'][0]);
                }

            } catch (\Exception $e) {
                $verification['error'] = __($e->getMessage());
            }
        }

        return $verification;
    }

    /**
     * @param $errorCode
     * @return \Magento\Framework\Phrase|mixed
     */
    private function getErrorMessage($errorCode)
    {
        $errorCodesGoogle = [
            'missing-input-secret' => __('The secret parameter is missing.'),
            'invalid-input-secret' => __('The secret parameter is invalid or malformed.'),
            'missing-input-response' => __('The response parameter is missing.'),
            'invalid-input-response' => __('The response parameter is invalid or malformed.'),
            'bad-request' => __('The request is invalid or malformed.')
        ];

        if (array_key_exists($errorCode, $errorCodesGoogle)) {
            return $errorCodesGoogle[$errorCode];
        }

        return __('Something is wrong.');
    }
}
