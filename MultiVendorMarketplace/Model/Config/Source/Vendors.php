<?php

namespace Vinsol\MultiVendorMarketplace\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * 
 */
class Vendors extends AbstractSource implements \Magento\Framework\Option\ArrayInterface
{
  protected $vendor;
  protected $user;
  public function __construct(
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    \Magento\User\Model\UserFactory $userFactory
  )
  {
    $this->vendor = $vendorFactory->create();
    $this->user = $userFactory->create();
    // parent::__construct();
  }

  // public function getAllOptions()
  // {
  //   return $this->toOptionArray();
  // }

  public function getAllOptions()
  {
    // $admin = $this->user->load('')

    $array = [
      ['value' => '', 'label' => __('Select Vendor')]
    ];

    $collection = $this->vendor->getCollection();

    if ($collection->count()) {
      foreach ($collection as $key => $value) {
        $id = $value->getData('user_id');
        $vendor = $value->getData('username');
        $pair = [ 
          'value' => $id,
          'label' => $vendor
        ];
        $array[] = $pair;
      }
    }
    return $array;
  }
}