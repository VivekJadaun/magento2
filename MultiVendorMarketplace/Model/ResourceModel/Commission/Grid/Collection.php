<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Commission\Grid;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Vinsol\MultiVendorMarketplace\Model\ResourceModel\Commission\Collection as CommissionCollection;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
// use Magento\Framework\App\State;

class Collection extends CommissionCollection implements SearchResultInterface
{

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        // \Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot $entitySnapshot,
        $connection = null,
        $resource = null,
        Attribute $productAttribute,
        $mainTable,
        $resourceModel,
        $model = \Magento\Framework\View\Element\UiComponent\DataProvider\Document::class
    ) {
        parent::__construct(
            $entityFactory, 
            $logger, 
            $fetchStrategy, 
            $eventManager, 
            $connection, 
            $resource, 
            $productAttribute
        );
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    public function getAggregations()
    {
        return $this->aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    public function getSearchCriteria()
    {
        return null;
    }

    public function setSearchCriteria(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null
    ) {
        return $this;
    }

    
    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    public function setItems(array $items = null)
    {
        return $this;
    }
}