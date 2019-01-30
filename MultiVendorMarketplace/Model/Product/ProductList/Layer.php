<?php

namespace Vinsol\MultiVendorMarketplace\Model\Product\ProductList;

class Layer extends \Magento\Catalog\Model\Layer
{
  protected $vendor;
  protected $request;
  protected $productCollection;
  
  public function __construct(
    \Magento\Catalog\Model\Layer\ContextInterface $context,
    \Magento\Catalog\Model\Layer\StateFactory $layerStateFactory,
    \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attributeCollectionFactory,
    \Magento\Catalog\Model\ResourceModel\Product $catalogProduct,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Framework\Registry $registry,
    \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
    \Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
    // \Magento\Framework\App\Action\Context $appContext,
    array $data = []
  )
  {
    // $this->request = $appContext->getRequest();
    $this->vendor = $vendorFactory->create();
    $this->productCollection = $catalogProduct->getCollection();
    parent::__construct($context, $layerStateFactory, $attributeCollectionFactory, $catalogProduct, $storeManager, $registry, $categoryRepository, $data); 
  }

  public function getProductCollection()
  {
    $vendorId = $this->request->getParam('id');
    // $vendorId = 11;
    if ($vendorId) {
      $this->vendor->load($vendorId);
      $collection = $this->productCollection->addAttributeToFilter('user_id', $this->vendor->getUserId());
    }
    return $collection;
  }

  // public function prepareProductCollection($collection)
  // {
  //   // parent::prepareProductCollection($collection);
  //   $this->collection->addAttributeToFilter('user_id', $this->vendor->getUserId());
  //   return $this;
  // }

}