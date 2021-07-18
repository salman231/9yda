<?php
namespace Magento\Framework\Search\Adapter\Mysql\Adapter;

/**
 * Interceptor class for @see \Magento\Framework\Search\Adapter\Mysql\Adapter
 */
class Interceptor extends \Magento\Framework\Search\Adapter\Mysql\Adapter implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Search\Adapter\Mysql\Mapper $mapper, \Magento\Framework\Search\Adapter\Mysql\ResponseFactory $responseFactory, \Magento\Framework\App\ResourceConnection $resource, \Magento\Framework\Search\Adapter\Mysql\Aggregation\Builder $aggregationBuilder, \Magento\Framework\Search\Adapter\Mysql\TemporaryStorageFactory $temporaryStorageFactory)
    {
        $this->___init();
        parent::__construct($mapper, $responseFactory, $resource, $aggregationBuilder, $temporaryStorageFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function query(\Magento\Framework\Search\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'query');
        if (!$pluginInfo) {
            return parent::query($request);
        } else {
            return $this->___callPlugins('query', func_get_args(), $pluginInfo);
        }
    }
}
