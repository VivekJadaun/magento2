<?php
namespace Vinsol\MultiVendorMarketplace\Ui\DataProvider\Vendor;

use Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor\CollectionFactory;

class VendorDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    const ADMIN_ROLE_GROUP = 'Administrators';
    /**
     * Vendor collection
     *
     * @var \Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]
     */
    protected $addFieldStrategies;

    /**
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    protected $addFilterStrategies;

    /**
     * @var \Magento\Backend\App\Action\Context
     */
    protected $context;

    /**
     * @var \Magento\Backend\Model\Auth\Credential\StorageInterface
     */
    protected $user;

    /**
     * @var \Magento\Authorization\Model\Role
     */    
    protected $role;

    /**
     * Construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[] $addFieldStrategies
     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
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

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $this->user = $this->context->getAuth()->getUser();
        $this->role = $this->user->getRole();

        if (!$this->getCollection()->isLoaded()) {
            // if ($this->role->getRoleName() === \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_NAME) {
                // $this->getCollection()->addAttributeToFilter('user_id', $this->user->getId())->load();
            // } else if ($this->role->getRoleName() === self::ADMIN_ROLE_GROUP) {
                $this->getCollection()->load();
            // }
        }
        $items = $this->getCollection()->toArray();
        
        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_values($items),
        ];
    }

    /**
     * Add field to select
     *
     * @param string|array $field
     * @param string|null $alias
     * @return void
     */
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
}
