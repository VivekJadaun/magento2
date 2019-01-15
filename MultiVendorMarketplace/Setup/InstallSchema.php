<?php
	
	namespace Vinsol\MultiVendorMarketplace\Setup;

	use Magento\Framework\Setup\InstallSchemaInterface;
	use Magento\Framework\Setup\ModuleContextInterface;
	use Magento\Framework\Setup\SchemaSetupInterface; 

	class InstallSchema implements InstallSchemaInterface
	{
		
		public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
		{
			$setup->startSetup();
			$vendorEntity = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY; 


			// VENDOR_ENTITY TABLE SETUP -------------------------------------------

			$vendorTable = $setup->getConnection()
				->newTable($setup->getTable($vendorEntity . '_entity'))
				->addColumn(
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
					'primary' => true,
					'identity' => true,
					'unsigned' => true, 
					'nullable' => false
					],
					'Entity ID'
				)
				->addColumn(
					'commission',
					\Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
					null,
					[
					'nullable' => false,
					'unsigned' => true,
					'default' => 0
					],
					'Commission in %'
				)
				->addColumn(
					'sort_order',
					\Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
					null,
					[
					'default' => null,
					],
					'Sort Order'
				)
				->addColumn(
					'user_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
					'unsigned' => true,
					],
					'User Id corresponding to admin_user table user'
				)
				->addIndex(
					$setup->getIdxName($vendorEntity . '_entity', ['sort_order']),
					['sort_order']
				)
				->addForeignKey(
					$setup->getFkName($vendorEntity . '_entity', 'user_id', $setup->getTable('admin_user'), 'user_id'),
					'user_id',
					$setup->getTable('admin_user'),
					'user_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->setComment('Marketplace Vendor Table');
			$setup->getConnection()->createTable($vendorTable);

			
			// VENDOR_ENTITY_TYPE TABLES SETUP -------------------------------------------

			//TYPE INT
			$vendorIntegerTypeTable = $setup->getConnection()
				->newTable($setup->getTable($vendorEntity . '_entity_int'))
				->addColumn(
					'value_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'primary' => true,
						'identity' => true, 
						'unsigned' => true, 
						'nullable' => false
					],
					'Value ID'
				)
				->addColumn(
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
					null,
					[
						'nullable' => false,
						'unsigned' => true,
					],
					'Attribute ID'
				)
				->addColumn(
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'nullable' => false,
						'unsigned' => true
					],
					'Entity ID'
				)
				->addColumn(
					'value',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'nullable' => false
					],
					'Value'
				)
				->addIndex(
					$setup->getIdxName(
						$vendorEntity . '_entity_int', 
						['entity_id', 'attribute_id'], 
						\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
					),
					['entity_id', 'attribute_id'],
					['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
				)
				->addIndex(
					$setup->getIdxName($vendorEntity . '_entity_int', ['attribute_id']),
					['attribute_id']
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_int', 'attribute_id', 
						$setup->getTable('eav_attribute'), 'attribute_id'
					), 
					'attribute_id',
					$setup->getTable('eav_attribute'),
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_int', 'entity_id', 
						$setup->getTable($vendorEntity . '_entity'), 'entity_id'
					), 
					'entity_id',
					$setup->getTable($vendorEntity . '_entity'),
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->setComment('Marketplace Vendor Integer Values Table');
			$setup->getConnection()->createTable($vendorIntegerTypeTable);

			//TYPE DECIMAL
			$vendorDecimalTypeTable = $setup->getConnection()
				->newTable($setup->getTable($vendorEntity . '_entity_decimal'))
				->addColumn(
					'value_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'primary' => true,
						'identity' => true, 
						'unsigned' => true, 
						'nullable' => false
					],
					'Value ID'
				)
				->addColumn(
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
					null,
					[
						'nullable' => false,
						'unsigned' => true,
					],
					'Attribute ID'
				)
				->addColumn(
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'nullable' => false,
						'unsigned' => true
					],
					'Entity ID'
				)
				->addColumn(
					'value',
					\Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
					'12,4',
					[
						'nullable' => false
					],
					'Value'
				)
				->addIndex(
					$setup->getIdxName(
						$vendorEntity . '_entity_decimal', 
						['entity_id', 'attribute_id'], 
						\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
					),
					['entity_id', 'attribute_id'],
					['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
				)
				->addIndex(
					$setup->getIdxName($vendorEntity . '_entity_decimal', ['attribute_id']),
					['attribute_id']
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_decimal', 'attribute_id', 
						$setup->getTable('eav_attribute'), 'attribute_id'
					), 
					'attribute_id',
					$setup->getTable('eav_attribute'),
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_decimal', 'entity_id', 
						$setup->getTable($vendorEntity . '_entity'), 'entity_id'
					), 
					'entity_id',
					$setup->getTable($vendorEntity . '_entity'),
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->setComment('Marketplace Vendor Decimal Values Table');
			$setup->getConnection()->createTable($vendorDecimalTypeTable);

			//TYPE TEXT
			$vendorTextTypeTable = $setup->getConnection()
				->newTable($setup->getTable($vendorEntity . '_entity_text'))
				->addColumn(
					'value_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'primary' => true,
						'identity' => true, 
							'unsigned' => true, 
							'nullable' => false
					],
					'Value ID'
				)
				->addColumn(
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
					null,
					[
						'nullable' => false,
						'unsigned' => true,
					],
					'Attribute ID'
				)
				->addColumn(
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'nullable' => false,
						'unsigned' => true
					],
					'Entity ID'
				)
				->addColumn(
					'value',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					null,
					[
						'nullable' => false
					],
					'Value'
				)
				->addIndex(
					$setup->getIdxName(
						$vendorEntity . '_entity_text', 
						['entity_id', 'attribute_id'], 
						\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
					),
					['entity_id', 'attribute_id'],
					['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
				)
				->addIndex(
					$setup->getIdxName($vendorEntity . '_entity_text', ['attribute_id']),
					['attribute_id']
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_text', 'attribute_id', 
						$setup->getTable('eav_attribute'), 'attribute_id'
					), 
					'attribute_id',
					$setup->getTable('eav_attribute'),
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_text', 'entity_id', 
						$setup->getTable($vendorEntity . '_entity'), 'entity_id'
					), 
					'entity_id',
					$setup->getTable($vendorEntity . '_entity'),
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->setComment('Marketplace Vendor Text Values Table');
			$setup->getConnection()->createTable($vendorTextTypeTable);
			
			//TYPE DATETIME
			$vendorDatetimeTypeTable = $setup->getConnection()
				->newTable($setup->getTable($vendorEntity . '_entity_datetime'))
				->addColumn(
					'value_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'primary' => true,
						'identity' => true, 
							'unsigned' => true, 
							'nullable' => false
					],
					'Value ID'
				)
				->addColumn(
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
					null,
					[
						'nullable' => false,
						'unsigned' => true,
					],
					'Attribute ID'
				)
				->addColumn(
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'nullable' => false,
						'unsigned' => true
					],
					'Entity ID'
				)
				->addColumn(
					'value',
					\Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
					null,
					[
						'nullable' => true
					],
					'Value'
				)
				->addIndex(
					$setup->getIdxName(
						$vendorEntity . '_entity_datetime', 
						['entity_id', 'attribute_id'], 
						\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
					),
					['entity_id', 'attribute_id'],
					['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
				)
				->addIndex(
					$setup->getIdxName($vendorEntity . '_entity_datetime', ['attribute_id']),
					['attribute_id']
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_datetime', 'attribute_id', 
						$setup->getTable('eav_attribute'), 'attribute_id'
					), 
					'attribute_id',
					$setup->getTable('eav_attribute'),
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_datetime', 'entity_id', 
						$setup->getTable($vendorEntity . '_entity'), 'entity_id'
					), 
					'entity_id',
					$setup->getTable($vendorEntity . '_entity'),
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->setComment('Marketplace Vendor Datetime Values Table');
			$setup->getConnection()->createTable($vendorDatetimeTypeTable);

			//TYPE VARCHAR
			$vendorVarcharTypeTable = $setup->getConnection()
				->newTable($setup->getTable($vendorEntity . '_entity_varchar'))
				->addColumn(
					'value_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'primary' => true,
						'identity' => true, 
						'unsigned' => true, 
						'nullable' => false
					],
					'Value ID'
				)
				->addColumn(
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
					null,
					[
						'nullable' => false,
						'unsigned' => true,
					],
					'Attribute ID'
				)
				->addColumn(
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'nullable' => false,
						'unsigned' => true
					],
					'Entity ID'
				)
				->addColumn(
					'value',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[
						'nullable' => true
					],
					'Value'
				)
				->addIndex(
					$setup->getIdxName(
						$vendorEntity . '_entity_varchar', 
						['entity_id', 'attribute_id'], 
						\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
					),
					['entity_id', 'attribute_id'],
					['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
				)
				->addIndex(
					$setup->getIdxName($vendorEntity . '_entity_varchar', ['attribute_id']),
					['attribute_id']
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_varchar', 'attribute_id', 
						$setup->getTable('eav_attribute'), 'attribute_id'
					), 
					'attribute_id',
					$setup->getTable('eav_attribute'),
					'attribute_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->addForeignKey(
					$setup->getFkName(
						$vendorEntity . '_entity_varchar', 'entity_id', 
						$setup->getTable($vendorEntity . '_entity'), 'entity_id'
					), 
					'entity_id',
					$setup->getTable($vendorEntity . '_entity'),
					'entity_id',
					\Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
				)
				->setComment('Marketplace Vendor Varchar Values Table');
			$setup->getConnection()->createTable($vendorVarcharTypeTable);

			$setup->endSetup();
		}
	}
