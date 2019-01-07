<?php

namespace Vinsol\MultiVendorMarketplace\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;

class Active extends \Magento\Ui\Component\Listing\Columns\Column
{
  protected $storeManager;
  protected $vendor;
  public function __construct(
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    ContextInterface $context,
    UiComponentFactory $uiComponentFactory,
    StoreManagerInterface $storeManager,
    array $components = [],
    array $data = []
  ) {
    $this->storeManager = $storeManager;
    $this->vendor = $vendorFactory->create();
    parent::__construct($context, $uiComponentFactory, $components, $data);
  }
  public function prepareDataSource(array $dataSource) {
    // var_dump($this->vendor->getCollection()->load(true)->getSelectSql());
    // print_r($this->vendor->getCollection()->load()->getData());
    $dataSource['data']['items'] = $this->vendor->getCollection()->load()->getData();
    // print_r($dataSource['data']['items']);
    if(isset($dataSource['data']['items'])) {
      foreach($dataSource['data']['items'] as & $item) {
        if($item) {
          $item['is_active'] = (($item['is_active'] == 1) ? __('Yes') : __('No'));
        }
      }
    }
    return $dataSource;
  }
}