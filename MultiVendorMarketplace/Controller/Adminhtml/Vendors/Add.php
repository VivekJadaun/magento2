<?php

namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Vendors;

use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Add extends \Magento\Backend\App\Action {
  public function execute(){
    $this->_forward('edit');
  }
}