<?php

  namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel;

  use Magento\Framework\DataObject;

  class Vendor extends \Magento\Eav\Model\Entity\AbstractEntity
  {
    protected $user;
    protected $productCollection;
    protected $productAction;
    protected $productRepository;
    // protected $productVisibilty;
    protected $messageManager;
    protected $storeManager;

    private $productStatusChanged = false;

    public function __construct(
      \Magento\Eav\Model\Entity\Context $context,
      \Magento\User\Model\UserFactory $userFactory,
      \Magento\Framework\Message\Manager $messageManager,
      \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
      // \Magento\Catalog\Model\Product\Visibility $productVisibilty,
      \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
      \Magento\Catalog\Model\ResourceModel\Product\ActionFactory $productActionFactory,
      \Magento\Store\Model\StoreManagerInterface $storeManager,
      $data = []
    )
    {
      $this->user = $userFactory->create();
      $this->productCollection = $productCollectionFactory->create();
      $this->productAction = $productActionFactory->create();
      $this->productRepository = $productRepositoryInterface;
      // $this->productVisibilty = $productVisibilty;
      $this->messageManager = $messageManager;
      $this->storeManager = $storeManager;
      parent::__construct($context, $data);
    }

    protected function _construct()
    {
      $this->_read = 'marketplace_vendor_read';
      $this->_write = 'marketplace_vendor_write';
    }

    public function getEntityType()
    {
      if(empty($this->_type)) {
        $this->setType(\Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY);
      }
      return parent::getEntityType();
    }

    protected function _beforeSave(DataObject $object)
    {
      $object->setUserType(\Magento\Authorization\Model\UserContextInterface::USER_TYPE_GUEST);

      $this->updateUser($object)->updateLogo($object)->updateBanner($object)->updateProductStatus($object);

      parent::_beforeSave($object);
    }

    // protected function _afterSave(DataObject $object)
    // {
    //   parent::_afterSave($object);

    //   $data = $object->getData();
    //   $userId = $object->getUserId();
    //   $username = $object->getUsername();
    //   // $this->user->load
    //   if ($object->getIsActive() != 1) {

    //     $storesIds = array_keys($this->storeManager->getStores()); 

    //     $this->productCollection
    //       ->addAttributeToFilter('user_id', $userId)
    //       // ->addAttributeToFilter('status', [])  <============================================================
    //       ->load();

    //     // THIS IS HELPFUL WHEN TO RESTORE PRODUCTS TO THEIR PREVIOUS STATUS ON VENDOR RE-ENABLE
    //     $collectionIds = $this->productCollection->getAllIds();  

    //     try {
    //       // $this->productCollection->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE);
    //       // $this->productCollection->save(); 
    //       $this->productAction->updateAttributes($collectionIds, ['status' => \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED], $storeId);   
    //     } catch (\Exception $e) {
    //       $this->messageManager->addException($e);
    //     }

    //     $this->messageManager->addSuccess(__("$username Products Visibility Set To : Not visible (1)"));

    //   } else {
    //     $this->productCollection->addAttributeToFilter('user_id', $userId)->load();

    //     try {
    //       $this->productCollection->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
    //       $this->productCollection->save();    
    //     } catch (\Exception $e) {
    //       $this->messageManager->addException($e);
    //     }

    //     $this->messageManager->addSuccess(__("$username Products Visibility Set To : Catalog + Search (4)"));
    //   }

    // }

    private function updateUser(DataObject & $object)
    {
        $this->user->load($object->getUserId());
        $data = $object->getData();
        $active = $object->getIsActive();
        $this->productStatusChanged = ($this->user->getIsActive() != $object->getIsActive());

        // if ($this->user->getId()) {        //REMAIN COMMENTED
        $this->user->setData($data);
        try {
            // $this->messageManager->addSuccess(__("vendor updated!"));
            $this->user->save();
        } catch (\Exception $e) {
            $this->messageManager->addException($e);
        }
        // } 
        $object->setUserId($this->user->getId());
        return $this;
    }

    private function updateLogo(DataObject & $object)
    {
        if (isset($_FILES['logo']['name'])) {
            $object->setLogo($_FILES['logo']['name']);
        }
        return $this;
    }

    private function updateBanner(DataObject & $object)
    {
        if (isset($_FILES['banner']['name'])) {
            $object->setBanner($_FILES['banner']['name']);
        }
        return $this;
    }

    private function updateProductStatus(DataObject & $object)
    {
        if ($this->productStatusChanged) {

            $storesIds = array_keys($this->storeManager->getStores()); 
            $userId = $object->getUserId();
            $username = $object->getUsername();

            $this->productCollection
              ->addAttributeToFilter('user_id', $userId)
              // ->addAttributeToFilter('status', [])  <============================================================
              ->load();

            // THIS IS HELPFUL WHEN TO RESTORE PRODUCTS TO THEIR PREVIOUS STATUS ON VENDOR RE-ENABLE (set this in registry)
            $collectionIds = $this->productCollection->getAllIds();  

            if ($object->getIsActive()) {
                try {
                    foreach ($collectionIds as $productId) {
                        $productDataObject = $this->productRepository->getbyId($productId);
                        $productDataObject
                        ->setData('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
                        // ->setData('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED);
                        $this->productRepository->save($productDataObject);
                    }
                    
                    $this->messageManager->addSuccess(__("$username`s all products have been enabled!"));
                } catch (\Exception $e) {
                    $this->messageManager->addException($e);
                }
            } else {
                try {
                    foreach ($collectionIds as $productId) {
                        $productDataObject = $this->productRepository->getbyId($productId);
                        $productDataObject
                        ->setData('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE);
                        // ->setData('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
                        $this->productRepository->save($productDataObject);
                    }

                    $this->messageManager->addSuccess(__("$username`s products have been disabled!"));
                } catch (\Exception $e) {
                    $this->messageManager->addException($e);
                }
            }
      }

      return $this;
    }

    protected function _afterDelete(DataObject $object)
    {
      $userId = $object->getUserId();

      $this->productCollection->addAttributeToFilter('user_id', $userId)->load()->delete();

      $this->user->load($userId);
      $this->user->delete();

      parent::_afterDelete($object);
    }
  }
