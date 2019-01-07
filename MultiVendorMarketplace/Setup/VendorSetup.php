<?php

  namespace Vinsol\MultiVendorMarketplace\Setup;

  use Magento\Eav\Setup\EavSetup;

  class VendorSetup extends EavSetup
  {
    
    function getDefaultEntities()
    {
		$vendorEntity = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY;
    $adminUser = \Vinsol\MultiVendorMarketplace\Model\Vendor::ADMIN_USER;
    $roleTable = \Vinsol\MultiVendorMarketplace\Model\Vendor::ROLE_TABLE;

		$entities = [
			$vendorEntity => [
				'entity_model' => 'Vinsol\MultiVendorMarketplace\Model\ResourceModel\Vendor',
				'table' => $vendorEntity . '_entity',
				'attributes' => [
          'commission' => [
            'type' => 'static'
          ],
					'sort_order' => [
            'type' => 'static'
          ],
          'user_id' => [
            'type' => 'static'
          ]
				]
			],

      // $adminUser => [
      //   'entity_model' => 'Magento\User\Model\ResourceModel\User',
      //   'table' => $adminUser,
      //   'attributes' => [
      //     'firstname' => [
      //       'type' => 'varchar'
      //     ],
      //     'lastname' => [
      //       'type' => 'varchar'
      //     ],
      //     'email' => [
      //       'type' => 'static'
      //     ],
      //     'username' => [
      //       'type' => 'static'
      //     ],
      //     'password' => [
      //       'type' => 'static'
      //     ],
      //     'created' => [
      //       'type' => 'static'
      //     ],
      //     'is_active' => [
      //       'type' => 'static'
      //     ]          
      //   ]
      // ]

      // $roleTable = [
      //   'entity_model' => 'Magento\Authorization\Model\ResourceModel\Role',
      //   'table' => $roleTable,
      //   'attributes' => [
      //     'role_id' => [
      //       'type' => 'static'
      //     ],
      //     'role_name' => [
      //       'type' => 'static'
      //     ]
      //   ]
      // ]
		];

    return $entities;
    }
  }