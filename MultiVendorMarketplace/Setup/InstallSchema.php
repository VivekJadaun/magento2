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
	 //      ->addColumn(
			// 'first_name',
			// \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			// 255,
			// [
			// 'nullable' => false
			// ],
			// 'First Name'
	 //      )
	 //      ->addColumn(
			// 'last_name',
			// \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			// 255,
			// [
			// 'nullable' => true
			// ],
			// 'Last Name'
	 //      )
				->addColumn(
					'display_name',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[
					'nullable' => false
					],
					'Display Name'
				)
				->addColumn(
					'username',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[
					'nullable' => false
					],
					'Username'
				)
				->addColumn(
					'password',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[
					'nullable' => false
					],
					'Password Hash'
				)
				->addColumn(
					'created_at',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					[
					'nullable' => false
					],
					'Vendor creation timestamp'
				)
				->addColumn(
					'is_active',
					\Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
					null,
					[
					'nullable' => false, 
					'default' => 1
					],
					'Is Active'
				)
				->addColumn(
					'commission_perc',
					\Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
					null,
					[
					'nullable' => false,
					'unsigned' => true
					],
					'Commission Percentage'
				)
				->addColumn(
					'contact_no',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					20,
					[
					'nullable' => false,
					],
							'Contact Number'
				)
				->addColumn(
					'email',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[
					'nullable' => false
					],
					'Email Address'
				)
	 //      ->addColumn(
			// 'address',
			// \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			// 255,
			// [
			// 'nullable' => false
			// ],
			// 'Vendor Address'
	 //      )
				->addColumn(
					'role_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
					'nullable' => true,
					'unsigned' => true
					],
					'Vendor Role Id'
				)
	 //      ->addColumn(
			// 'logo',
			// \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			// 255,
			// [
			// 'nullable' => true
			// ],
			// 'Vendor Logo'
	 //      )
	 //      ->addColumn(
			// 'banner',
			// \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
			// 255,
			// [
			// 'nullable' => true
			// ],
			// 'Vendor Banner'
	 //      )
				->addColumn(
					'sort_order',
					\Magento\Framework\Db\Ddl\Table::TYPE_INTEGER,
					null,
					[
					'default' => 0,
					],
					'Sort Order'
				)
				->addIndex(
					$setup->getIdxName($vendorEntity . '_entity', ['sort_order']),
					['sort_order']
						)
						->addIndex(
					$setup->getIdxName($vendorEntity . '_entity', ['is_active']),
					['is_active']
				)
				->addIndex(
					$setup->getIdxName($vendorEntity . '_entity', ['email'], \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE),
					['email'],
					['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
				)
				->addForeignKey(
					$setup->getFkName($vendorEntity . '_entity', 'role_id', $setup->getTable('authorization_role'), 'role_id'),
					'role_id',
					$setup->getTable('authorization_role'),
					'role_id'
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
			'attribute_id'
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
			'attribute_id'
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
			'attribute_id'
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
			'attribute_id'
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
			'attribute_id'
				)
				->setComment('Marketplace Vendor Varchar Values Table');
			$setup->getConnection()->createTable($vendorVarcharTypeTable);


			$setup->endSetup();
		}
	}
