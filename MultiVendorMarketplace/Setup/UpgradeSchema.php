<?php
  namespace Vinsol\MultiVendorMarketplace\Setup;

  use Magento\Framework\Setup\UpgradeSchemaInterface;
  use Magento\Framework\Setup\ModuleContextInterface;
  use Magento\Framework\Setup\SchemaSetupInterface;

  class UpgradeSchema implements UpgradeSchemaInterface
  {
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
      $setup->startSetup();

      if (version_compare($context->getVersion(), '1.1.1', '<')) {

      //   $vendorEntity = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY;

      //   $setup->getTable($vendorEntity . '_entity')
      //     ->addForeignKey(
      //       $setup->getFkName($vendorEntity . '_entity', 'user_id', $setup->getTable('admin_user'), 'user_id'),
      //       'user_id',
      //       $setup->getTable('admin_user'),
      //       'user_id',
      //       \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
      //   );
      }

      $setup->endSetup();
    }
  }
