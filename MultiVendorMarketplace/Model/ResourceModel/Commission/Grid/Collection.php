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
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Eav\Model\EntityFactory $eavEntityFactory,
        \Magento\Eav\Model\ResourceModel\Helper $resourceHelper,
        \Magento\Framework\Validator\UniversalFactory $universalFactory,
        $connection = null,
        \Magento\Framework\Message\Manager $messageManager,
        \Magento\Authorization\Model\RoleFactory $roleFactory,
        Attribute $productAttribute,
        $mainTable,
        $resourceModel,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document'
    ) {
        parent::__construct(
            $entityFactory, 
            $logger, 
            $fetchStrategy,
            $eventManager, 
            $eavConfig, 
            $resource, 
            $eavEntityFactory, 
            $resourceHelper, 
            $universalFactory,
            $connection, 
            $messageManager, 
            $roleFactory,
            $productAttribute
        );
        $this->_init($model, $resourceModel);
        // $this->setMainTable($mainTable);
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