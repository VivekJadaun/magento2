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

    protected $from;
    protected $to;

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
        
        $from = $this->getFrom();
        $to = $this->getTo();

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
            )->columns('SUM(qty_shipped) AS items_sold'
            )->columns('SUM(price * qty_shipped) AS total_sales'
            )->columns('(SUM(price * qty_shipped) * commission / 100) AS commission_amount'
            )->where(
                "thirdTable.attribute_id = ?", $attributeId
            )->where(
                "fifthTable.created_at BETWEEN '$from' AND '$to'"
            )->group('secondTable.entity_id');

        // var_dump($this->getSelect()->__toString());

        return $this;

    }

    public function setFrom($from)
    {
        $this->from = $from || $this->from;

        return $this;
    }

    public function setTo($to)
    {
        $this->to = $to || $this->to;

        return $this;
    }

    public function getFrom()
    {
        return $this->from || date('Y-m-d', 0);
    }

    public function getTo()
    {
        return $this->to || date('Y-m-d');
    }
}