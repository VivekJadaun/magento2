<?php
namespace Vinsol\MultiVendorMarketplace\Plugin;

/**
 * 
 */
class Layer
{
  // protected $context;
  // protected $vendor;

  // public function __construct(
  //   \Magento\Framework\App\Action\Context $context,
  //   \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory
  // )
  // {
  //   $this->request = $context->getRequest();
  //   $this->vendor = $vendorFactory->create();
  // }
  // public function aroundGetProductCollection (
  //   \Magento\Catalog\Model\Layer $subject,
  //   \Closure $proceed
  // )
  // {
  //   $result = $proceed();
  //   $id = $this->request->getParam('id');
  //   if ($id) {
  //     $this->vendor->load($id);
  //     if ($this->vendor->getId()) {
  //       $result->addAttributeToFilter('user_id', $this->vendor->getUserId());
  //     }
  //   }
  //   return $result;
  // }
}