<?php
namespace Magento\Eav\Model\Attribute\Data\Date;

/**
 * Interceptor class for @see \Magento\Eav\Model\Attribute\Data\Date
 */
class Interceptor extends \Magento\Eav\Model\Attribute\Data\Date implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Locale\ResolverInterface $localeResolver)
    {
        $this->___init();
        parent::__construct($localeDate, $logger, $localeResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function validateValue($value)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateValue');
        if (!$pluginInfo) {
            return parent::validateValue($value);
        } else {
            return $this->___callPlugins('validateValue', func_get_args(), $pluginInfo);
        }
    }
}
