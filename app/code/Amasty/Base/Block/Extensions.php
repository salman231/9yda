<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Base
 */


namespace Amasty\Base\Block;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Extensions
 * @package Amasty\Base\Block
 */
class Extensions extends \Magento\Config\Block\System\Config\Form\Fieldset
{
    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    private $moduleList;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    private $layoutFactory;

    /**
     * @var \Amasty\Base\Helper\Module
     */
    private $moduleHelper;

    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\View\Helper\Js $jsHelper,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Amasty\Base\Helper\Module $moduleHelper,
        array $data = []
    ) {
        parent::__construct($context, $authSession, $jsHelper, $data);

        $this->moduleList = $moduleList;
        $this->layoutFactory = $layoutFactory;
        $this->moduleHelper = $moduleHelper;
    }

    /**
     * Render fieldset html
     *
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $html = $this->_getHeaderHtml($element);

        $modules = $this->moduleList->getNames();

        $dispatchResult = new \Magento\Framework\DataObject($modules);
        $modules = $dispatchResult->toArray();

        sort($modules);
        foreach ($modules as $moduleName) {
            if (strstr($moduleName, 'Amasty_') === false
                || $moduleName === 'Amasty_Base'
                || in_array($moduleName, $this->moduleHelper->getRestrictedModules())
            ) {
                continue;
            }

            $html .= $this->_getFieldHtml($element, $moduleName);
        }

        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     */
    protected function _getFieldRenderer()
    {
        if (empty($this->_fieldRenderer)) {
            $this->_fieldRenderer = $this->_layout->createBlock(
                \Magento\Config\Block\System\Config\Form\Field::class
            );
        }

        return $this->_fieldRenderer;
    }

    /**
     * Read info about extension from composer json file
     *
     * @param $moduleCode
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function _getModuleInfo($moduleCode)
    {
        return $this->moduleHelper->getModuleInfo($moduleCode);
    }

    /**
     * @param $fieldset
     * @param $moduleCode
     *
     * @return string
     */
    protected function _getFieldHtml($fieldset, $moduleCode)
    {
        $module = $this->_getModuleInfo($moduleCode);
        if (!is_array($module)
            || !array_key_exists('version', $module)
            || !array_key_exists('description', $module)
        ) {
            return '';
        }

        $currentVer = $module['version'];
        $moduleName = $module['description'];
        $moduleName = $this->_replaceAmastyText($moduleName);
        $status =
            '<a target="_blank">
                <img src="' . $this->getViewFileUrl('Amasty_Base::images/ok.gif') . '" title="' . __("Installed") . '"/>
             </a>';

        $allExtensions = $this->moduleHelper->getAllExtensions();
        if ($allExtensions && isset($allExtensions[$moduleCode])) {
            $singleRecord = array_key_exists('name', $allExtensions[$moduleCode]);
            $ext = $singleRecord ? $allExtensions[$moduleCode] : end($allExtensions[$moduleCode]);

            $url = $ext['url'];
            $name = $ext['name'];
            $name = $this->_replaceAmastyText($name);
            $lastVer = $ext['version'];

            if ($url) {
                $moduleName =
                    '<a href="' . $url . '" target="_blank" title="' . $name . '">'
                    . $name .
                    '</a>';
            } else {
                $moduleName = $name;
            }

            if (version_compare($currentVer, $lastVer, '<')) {
                $status =
                    '<a href="' . $url . '" target="_blank">
                        <img src="' . $this->getViewFileUrl('Amasty_Base::images/update.gif') .
                    '" alt="' . __("Update available") . '" title="' . __("Update available")
                    . '"/></a>';
            }
        }

        // in case if module output disabled
        if ($this->_scopeConfig->getValue('advanced/modules_disable_output/' . $moduleCode)) {
            $href = isset($url) ? ' href="' . $url . '"' : '';
            $status =
                '<a' . $href . ' target="_blank">
                    <img src="' . $this->getViewFileUrl('Amasty_Base::images/bad.gif') .
                '" alt="' . __("Output disabled") . '" title="' . __("Output disabled")
                . '"/></a>';
        }

        $moduleName = $status . ' ' . $moduleName;

        $field = $fieldset->addField(
            $moduleCode,
            'label',
            [
                'name' => 'dummy',
                'label' => $moduleName,
                'value' => $currentVer,
            ]
        )->setRenderer($this->_getFieldRenderer());

        return $field->toHtml();
    }

    /**
     * @param $moduleName
     *
     * @return mixed
     */
    protected function _replaceAmastyText($moduleName)
    {
        $moduleName = str_replace('for Magento 2', '', $moduleName);
        $moduleName = str_replace('by Amasty', '', $moduleName);

        return $moduleName;
    }
}
