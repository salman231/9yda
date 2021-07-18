<?php
/**
 *
 * @category : FME
 * @Package  : FME_CheckoutOrderAttributesFields
 * @Author   : FME Extensions <support@fmeextensions.com>
 * @copyright Copyright 2018 © fmeextensions.com All right reserved
 * @license https://fmeextensions.com/LICENSE.txt
 */
namespace FME\CheckoutOrderAttributesFields\Model\File;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\Http;

class Uploader extends \Magento\Framework\File\Uploader
{
    protected $request;
    /**
     * Init upload
     *
     * @param string|array $fileId
     * @throws \Exception
     */
    public function __construct($fileId)
    {
        $this->_setCustomUploadFileId($fileId);
        if (!file_exists($this->_file['tmp_name'])) {
            $code = empty($this->_file['tmp_name']) ? self::TMP_NAME_EMPTY : 0;
            throw new \Exception('The file was not uploaded.', $code);
        } else {
            $this->_fileExists = true;
        }
    }
    /**
     * Set upload field id
     *
     * @param string|array $fileId
     * @return void
     * @throws \Exception
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function _setCustomUploadFileId($fileId)
    {
        if (is_array($fileId)) {
            $this->_uploadType = self::MULTIPLE_STYLE;
            $this->_file = $fileId;
        } else {

            if (empty($this->getRequest()->getFiles())) {
                throw new \Exception('$_FILES array is empty');
            }

            preg_match("/^(.*?)\[(.*?)\]$/", $fileId, $file);

            $filesArray = $this->getRequest()->getFiles();
            if (is_array($file) && count($file) > 0 && isset($file[0]) && isset($file[1])) {
                array_shift($file);
                $this->_uploadType = self::MULTIPLE_STYLE;

                $fileAttributes = $filesArray[$file[0]];
                preg_match("/^(.*?)\]\[(.*?)\$/", $file[1], $wasMultiArray);
                // preg_match("/^(.*?)\[(.*?)\$/", $file[1], $wasMultiArray2);
                
                $tmpVar = [];

                foreach ($fileAttributes as $attributeName => $attributeValue) {
                    
                    if ( is_array($attributeValue) &&
                        count($wasMultiArray) > 0 &&
                        isset($wasMultiArray[0]) &&
                        isset($wasMultiArray[1]) ) {
                        $imageName = "";
                        $tmpVar = $fileAttributes[$wasMultiArray[1]][$wasMultiArray[2]];
                        break;
                    }else{
                        $tmpVar[$attributeName] = $attributeValue[$file[1]];
                    }
                }

                $fileAttributes = $tmpVar;
                $this->_file = $fileAttributes;
            } elseif (!is_array($fileId) && isset($filesArray[$fileId])) {
                $this->_uploadType = self::SINGLE_STYLE;
                $this->_file = $filesArray[$fileId];
            } elseif ($fileId == '') {
                throw new \Exception('Invalid parameter given. A valid $_FILES[] identifier is expected.');
            }
        }
    }
    /**
     * Get property locker
     *
     * @return PropertyLocker
     */
    private function getRequest()
    {
        if (null === $this->request) {
            $this->request = ObjectManager::getInstance()->get(Http::class);
        }
        return $this->request;
    }
}
