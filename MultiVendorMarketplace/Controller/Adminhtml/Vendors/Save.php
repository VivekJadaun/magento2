<?php

namespace Vinsol\MultiVendorMarketplace\Controller\Adminhtml\Vendors;

use \Magento\Backend\App\Action;
use \Magento\Backend\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\App\Filesystem\DirectoryList;
use \Magento\Framework\Filesystem;

class Save extends \Magento\Backend\App\Action {

  protected $resultPageFactory;
  protected $resultPage;
  protected $session;
  protected $vendor;
  protected $user;
  protected $messageManager;
  protected $fileUploaderFactory;
  protected $mediaDirectory;

  public function __construct(
      \Magento\Backend\App\Action\Context $context, 
      \Magento\Framework\View\Result\PageFactory $resultPageFactory,
      \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
      \Magento\User\Model\UserFactory $userFactory,
      \Magento\Framework\Message\Manager $messageManager,
      \Magento\Backend\Model\Session $session,
      \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
      Filesystem $filesystem
    ){
    $this->resultPageFactory = $resultPageFactory;
    $this->vendor = $vendorFactory->create();
    $this->user = $userFactory->create();
    $this->session = $session;
    $this->messageManager = $messageManager;
    $this->fileUploaderFactory = $fileUploaderFactory;
    $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
    parent::__construct($context);
  }

  public function execute(){
    $vendorData = $this->getRequest()->getPostValue();
    $resultRedirect = $this->resultRedirectFactory->create();

    // $this->messageManager->addSuccess(http_build_query($this->getRequest()->getParams()));

    $username = $this->getRequest()->getParam('username');
    // if($id) {
    //   $this->vendor->load($id);
    // }
    // $vendorData['logo'] = $username . '/' . $vendorData['logo'];
    // $vendorData['banner'] = $username . '/' . $vendorData['banner'];
    $this->vendor->setData($vendorData);
    
    // if (!$id) {
    //   $id = $this->vendor->getId();
    // }
    $target = $this->mediaDirectory->getAbsolutePath("marketplace/$username/");
    // $path = $this->_filesystem->getDirectoryWrite(DirectoryList::MEDIA)->getAbsolutePath('images/');

    try {
      if (isset($_FILES['logo']) && ($_FILES['logo']['error'] === 0)) {
        $logo = $this->fileUploaderFactory->create(['fileId' => 'logo']);
        $logo->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);        
        $logo->setAllowRenameFiles(false);
        $logo->save($target);
        //ADD CODE TO DELETE PREVIOUS LOGO FILE BEFORE SAVING NEW UPLOAD
      }

      if (isset($_FILES['banner']) && ($_FILES['banner']['error'] === 0)) {
        $banner = $this->fileUploaderFactory->create(['fileId' => 'banner']);
        $banner->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);        
        $banner->setAllowRenameFiles(false);        
        $banner->save($target);
        //ADD CODE TO DELETE PREVIOUS BANNER FILE BEFORE SAVING NEW UPLOAD
      }

      $this->vendor->save();

      $this->messageManager->addSuccess(__('Record Saved.'));

      if ($this->getRequest()->getParam('back')) {
        return $resultRedirect->setPath('*/*/edit', ['id' => $this->vendor->getId(), '_current' => true]);
      }
      $this->session->setFormData(false);
      return $resultRedirect->setPath('*/*/');
    } catch (\Exception $ex) {
      $this->messageManager->addException($ex);
    }

    $this->_getSession()->setFormData($vendorData);
    return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
  }

  protected function _isAllowed(){
    return $this->_authorization->isAllowed('Vinsol_MultiVendorMarketplace::vendors');
  }
}