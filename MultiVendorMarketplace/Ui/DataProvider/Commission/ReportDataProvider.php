<?php
namespace Vinsol\MultiVendorMarketplace\Ui\DataProvider\Commission;

use Vinsol\MultiVendorMarketplace\Model\ResourceModel\Commission\CollectionFactory;

/**
 * 
 */
class ReportDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
        $this->context = $context;
    }

    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
            // $this->prepareData();
        }
        $items = $this->getCollection()->toArray();

        // var_dump(array_values($items['items']));

        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_values($items['items']),
        ];
    }

    public function addField($field, $alias = null)
    {
        if (isset($this->addFieldStrategies[$field])) {
            $this->addFieldStrategies[$field]->addField($this->getCollection(), $field, $alias);
        } else {
            parent::addField($field, $alias);
        }
    }

    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        if (isset($this->addFilterStrategies[$filter->getField()])) {
            $this->addFilterStrategies[$filter->getField()]
                ->addFilter(
                    $this->getCollection(),
                    $filter->getField(),
                    [$filter->getConditionType() => $filter->getValue()]
                );
        } else {
            parent::addFilter($filter);
        }
    }

    public function prepareData()
    {
        $items = $this->getCollection;
        return $items;
    }
}