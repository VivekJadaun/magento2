<?php
namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel\Commission;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\User\Model\ResourceModel\User\Collection as UserCollection;
// use Magento\Sales\Model\ResourceModel\Order\Item\Collection as SalesOrderItemCollection;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
// use Magento\Framework\App\State;

class Collection extends UserCollection
{
    const SALES_ORDER_ITEM = 'sales_order_item';
    const VENDOR_ENTITY = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY . '_entity';
    const VENDOR_ORDER = \Vinsol\MultiVendorMarketplace\Model\VendorOrder::VENDOR_ORDER_TABLE;
    const CATALOG_PRODUCT = \Magento\Catalog\Model\Product::ENTITY;
    const CATALOG_PRODUCT_ENTITY = \Magento\Catalog\Model\Product::ENTITY . '_entity';
    const CATALOG_PRODUCT_ENTITY_TYPE = \Magento\Catalog\Model\Product::ENTITY . '_entity_text';
    const ATTRIBUTE_CODE = \Vinsol\MultiVendorMarketplace\Setup\InstallData::USER_ID;

    protected $productAttribute;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        // \Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot $entitySnapshot,
        $connection = null,
        $resource = null,
        Attribute $productAttribute
    )
    {
        $this->productAttribute = $productAttribute;
        parent::__construct(
            $entityFactory, 
            $logger, 
            $fetchStrategy, 
            $eventManager, 
            $connection, 
            $resource
        );
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        
        $attributeId = $this->productAttribute->loadByCode(self::CATALOG_PRODUCT, self::ATTRIBUTE_CODE)->getId();

        $this->getSelect()
            ->joinInner(
                ['secondTable' => $this->getTable(self::VENDOR_ENTITY)],
                'main_table.user_id = secondTable.user_id',
                ['entity_id', 'commission']
            )->joinInner(
                ['thirdTable' => $this->getTable(self::CATALOG_PRODUCT_ENTITY_TYPE)],
                'secondTable.user_id = thirdTable.value',
                ['']
            )->joinInner(
                ['fourthTable' => $this->getTable(self::CATALOG_PRODUCT_ENTITY)],
                'fourthTable.entity_id = thirdTable.entity_id',
                ['']
            )->joinInner(
                ['fifthTable' => $this->getTable(self::SALES_ORDER_ITEM)],
                'fifthTable.product_id = fourthTable.entity_id',
                ['']
            )->columns('COUNT(item_id) AS items_sold'
            )->columns('SUM(price) AS total_sales'
            )->columns('(SUM(price) * commission / 100) AS commission_amount'
            )->where(
                "thirdTable.attribute_id = ?", $attributeId
            )->group('secondTable.entity_id');

        // var_dump($this->getSelect()->__toString());

        return $this;

    }
}