<?php

namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Vendors;

class Delete extends \Magento\Backend\App\Action
{
  protected $vendor;
  public function __construct(
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    \Magento\Backend\App\Action\Context $context
  )
  {
    $this->vendor = $vendorFactory->create();
    parent::__construct($context);
  }

  public function execute()
  {
    $id = $this->getRequest()->getParam('id');
    if ($id > 0) {
      $this->vendor->load($id);
      try {
        $this->vendor->delete();
        $this->messageManager->addSuccess(__('Vendor record deleted successfully!'));
        
      } catch (\Exception $e) {
        $this->messageManager->addError(__('Something went wrong!'));
      }
    }
    $this->_redirect('*/*/');
  }

  protected function _isAllowed()
  {
    return $this->_authorization->isAllowed('Vinsol_MultiVendorMarketplace::vendors_new');
  }
}