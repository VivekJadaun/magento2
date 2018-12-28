<?php

namespace Vinsol\MultiVendorMarketplace\Block\Adminhtml;

/**
 * 
 */
class Vendor extends \Magento\Backend\Block\Widget\Grid\Container
{
  
  public function __construct()
  {
    $this->_controller = 'adminhtml';
    $this->_blockGroup = 'Vinsol_MultiVendorMarketplace';
    $this->_headerText = __('Vendors');
    parent::_construct();
  }
}