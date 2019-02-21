<?php
  namespace Vinsol\MultiVendorMarketplace\Setup;

  use Magento\Framework\Setup\UpgradeSchemaInterface;
  use Magento\Framework\Setup\ModuleContextInterface;
  use Magento\Framework\Setup\SchemaSetupInterface;

  class UpgradeSchema implements UpgradeSchemaInterface
  {
    const VENDOR_ORDER_TABLE = \Vinsol\MultiVendorMarketplace\Model\VendorOrder::VENDOR_ORDER_TABLE;
    const VENDOR_INVOICE_TABLE = \Vinsol\MultiVendorMarketplace\Model\VendorInvoice::VENDOR_INVOICE_TABLE;
    const VENDOR_SHIPMENT_TABLE = \Vinsol\MultiVendorMarketplace\Model\VendorShipment::VENDOR_SHIPMENT_TABLE;
    const SALES_ORDER_TABLE = 'sales_order';
    const VENDOR_TABLE = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY . '_entity';
    const USER_TABLE = 'admin_user';

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
      $setup->startSetup();
      $vendorEntity = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY;

      if (version_compare($context->getVersion(), '1.1.2', '<')) {

        echo "CREATING TABLE " . self::VENDOR_ORDER_TABLE . " ... ";

        $vendorOrderTable = $setup->getConnection()
          ->newTable($setup->getTable(self::VENDOR_ORDER_TABLE))
          ->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
              'primary' => true,
              'identity' => true,
              'unsigned' => true,
              'nullable' => false
            ],
            'Entity Id'
          )
          ->addColumn(
            'order_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
              'unsigned' => true,
              'nullable' => false
            ],
            'Order Id'
          )
          // ->addColumn(
          //   'vendor_id',
          //   \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
          //   null,
          //   [
          //     'unsigned' => true,
          //     'nullable' => false
          //   ],
          //   'Vendor Id'
          // )
          ->addColumn(
            'user_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
              'unsigned' => true,
              'nullable' => false
            ],
            'User Id'
          )
          ->addIndex(
            $setup->getIdxName(self::VENDOR_ORDER_TABLE, ['order_id', 'user_id'], \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE),
            ['order_id', 'user_id'],
            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
          )
          // ->addForeignKey(
          //   $setup->getFkName(self::VENDOR_ORDER_TABLE, 'order_id', self::VENDOR_ORDER_TABLE, 'entity_id'),
          //   'order_id',
          //   self::SALES_ORDER_TABLE,
          //   'entity_id',
          //   \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
          // )
          // ->addForeignKey(
          //   $setup->getFkName(self::VENDOR_ORDER_TABLE, 'vendor_id', self::VENDOR_TABLE, 'entity_id'),
          //   'vendor_id',
          //   self::VENDOR_TABLE,
          //   'entity_id',
          //   \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
          // )
          // ->addForeignKey(
          //   $setup->getFkName(self::VENDOR_ORDER_TABLE, 'user_id', self::USER_TABLE, 'user_id'),
          //   'user_id',
          //   self::USER_TABLE,
          //   'user_id',
          //   \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
          // )
          ->setComment('Marketplace Vendor Order Table');

        $setup->getConnection()->createTable($vendorOrderTable);
      }

      if (version_compare($context->getVersion(), '1.1.3', '<')) {
        
        echo "CREATING TABLE " . self::VENDOR_INVOICE_TABLE . " ... ";

        $vendorInvoiceTable = $setup->getConnection()
          ->newTable($setup->getTable(self::VENDOR_INVOICE_TABLE))
          ->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
              'primary' => true,
              'identity' => true,
              'unsigned' => true,
              'nullable' => false
            ],
            'Entity Id'
          )
          ->addColumn(
            'invoice_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
              'unsigned' => true,
              'nullable' => false
            ],
            'Invoice Id'
          )
          ->addColumn(
            'user_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
              'unsigned' => true,
              'nullable' => false
            ],
            'User Id'
          )
          ->addIndex(
            $setup->getIdxName(self::VENDOR_INVOICE_TABLE, ['invoice_id', 'user_id'], \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE),
            ['invoice_id', 'user_id'],
            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
          )
          // ->addForeignKey(
          //   $setup->getFkName(self::VENDOR_INVOICE_TABLE, 'invoice_id', self::VENDOR_INVOICE_TABLE, 'entity_id'),
          //   'invoice_id',
          //   self::SALES_ORDER_TABLE,
          //   'entity_id',
          //   \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
          // )
          // ->addForeignKey(
          //   $setup->getFkName(self::VENDOR_INVOICE_TABLE, 'user_id', self::USER_TABLE, 'user_id'),
          //   'user_id',
          //   self::USER_TABLE,
          //   'user_id',
          //   \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
          // )
          ->setComment('Marketplace Vendor Invoice Table');

        $setup->getConnection()->createTable($vendorInvoiceTable);


        echo "CREATING TABLE " . self::VENDOR_SHIPMENT_TABLE . " ... ";

        $vendorShipmentTable = $setup->getConnection()
          ->newTable($setup->getTable(self::VENDOR_SHIPMENT_TABLE))
          ->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
              'primary' => true,
              'identity' => true,
              'unsigned' => true,
              'nullable' => false
            ],
            'Entity Id'
          )
          ->addColumn(
            'shipment_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
              'unsigned' => true,
              'nullable' => false
            ],
            'Shipment Id'
          )
          ->addColumn(
            'user_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
              'unsigned' => true,
              'nullable' => false
            ],
            'User Id'
          )
          ->addIndex(
            $setup->getIdxName(self::VENDOR_SHIPMENT_TABLE, ['shipment_id', 'user_id'], \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE),
            ['shipment_id', 'user_id'],
            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
          )
          // ->addForeignKey(
          //   $setup->getFkName(self::VENDOR_SHIPMENT_TABLE, 'shipment_id', self::VENDOR_SHIPMENT_TABLE, 'entity_id'),
          //   'shipment_id',
          //   self::SALES_ORDER_TABLE,
          //   'entity_id',
          //   \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
          // )
          // ->addForeignKey(
          //   $setup->getFkName(self::VENDOR_SHIPMENT_TABLE, 'user_id', self::USER_TABLE, 'user_id'),
          //   'user_id',
          //   self::USER_TABLE,
          //   'user_id',
          //   \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
          // )
          ->setComment('Marketplace Vendor Shipment Table');

        $setup->getConnection()->createTable($vendorShipmentTable);
      }
      echo "DONE";

      $setup->endSetup();
    }
  }
