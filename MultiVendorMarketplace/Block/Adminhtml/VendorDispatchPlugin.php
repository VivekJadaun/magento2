<?php 

namespace Vinsol\MultiVendorMarketplace\Block\Adminhtml;

/**
 * 
 */
class VendorDispatchPlugin
{
  
  public function beforeDispatch()
  {
    var_dump('Deleting vendor');
  }
}