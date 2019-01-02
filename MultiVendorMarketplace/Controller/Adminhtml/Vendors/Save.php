<?php

namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Vendors;

use \Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;

class Save extends \Magento\Backend\App\Action {
  protected $resultPageFactory;
  protected $resultPage;
  protected $session;
  protected $vendor;
  public function __construct(
      \Magento\Backend\App\Action\Context $context, 
      \Magento\Framework\View\Result\PageFactory $resultPageFactory,
      \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
      \Magento\Backend\Model\Session $session
    ){
    $this->resultPageFactory = $resultPageFactory;
    $this->vendor = $vendorFactory->create();
    $this->session = $session;
    parent::__construct($context);
  }
  public function execute(){
    $data = $this->getRequest()->getPostValue();
    $resultRedirect = $this->resultRedirectFactory->create();
    $id = $this->getRequest()->getParam('id');
    if($id) {
      $this->vendor->load($id);
    }
    $this->vendor->setData($data);
    try {
      $this->messageManager->addSuccess('before save');
      $this->vendor->save();
      $this->messageManager->addSuccess('after save');
      $this->messageManager->addSuccess(__('Record Saved.'));
      if ($this->getRequest()->getParam('back')) {
        return $resultRedirect->setPath('*/*/', ['id' => $this->vendor->getId(), '_current' => true]);
      }
      $this->session->setFormData(false);
      return $resultRedirect->setPath('*/*/');
    } catch (\Exception $ex) {
      $this->messageManager->addException(var_dump($ex));
    }
    $this->_getSession()->setFormData($data);
    return $resultRedirect->setPath('*/*/', ['id' => $this->getRequest()->getParam('id')]);
  }
  protected function _isAllowed(){
    return $this->_authorization->isAllowed('Vinsol_MultiVendorMarketplace::vendors');
  }
}