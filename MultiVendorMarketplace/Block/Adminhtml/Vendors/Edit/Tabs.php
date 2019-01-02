<?php
  namespace Vinsol\MultiVendorMarketplace\Block\Adminhtml\Vendors\Edit;
   
  class Tabs extends \Magento\Backend\Block\Widget\Tabs {
    protected function _construct(){
      parent::_construct();
      $this->setId('vendor_edit_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(__('Vendors'));
    }
    protected function _beforeToHtml(){
      $this->addTab(
        'general_data',
        [
          'label' => __('General'),
          'title' => __('General'),
          'content' => $this->getLayout()->createBlock('Vinsol\MultiVendorMarketplace\Block\Adminhtml\Vendors\Edit\Tab\General')->toHtml(),
          'active' => true
        ]
      );
      return parent::_beforeToHtml();
    }
  }

?>