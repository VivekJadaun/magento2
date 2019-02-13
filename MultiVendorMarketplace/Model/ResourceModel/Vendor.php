<?php

  namespace Vinsol\MultiVendorMarketplace\Model\ResourceModel;

  use Magento\Framework\DataObject;
  use Magento\UrlRewrite\Service\V1\Data\UrlRewrite as UrlRewriteService;

  class Vendor extends \Magento\Eav\Model\Entity\AbstractEntity
  {
    const REQUEST_PATH_PREFIX = 'vendors/';
    const TARGET_PATH_PREFIX = 'vendors/vendors/index/id/';
    const ENTITY_TYPE = \Vinsol\MultiVendorMarketplace\Model\Vendor::ENTITY;
    const REDIRECT_TYPE = 0;
    const STORE_ID = 1;

    private $_usernameChanged = false;
    private $_productStatusChanged = false;
    
    protected $user;
    protected $productCollection;
    protected $productAction;
    protected $productRepository;
    // protected $productVisibilty;
    protected $messageManager;
    protected $storeManager;
    protected $urlRewrite;
    protected $urlRewriteCollection;


    public function __construct(
      \Magento\Eav\Model\Entity\Context $context,
      \Magento\User\Model\UserFactory $userFactory,
      \Magento\Framework\Message\Manager $messageManager,
      \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
      // \Magento\Catalog\Model\Product\Visibility $productVisibilty,
      \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
      \Magento\Catalog\Model\ResourceModel\Product\ActionFactory $productActionFactory,
      \Magento\Store\Model\StoreManagerInterface $storeManager,
      \Magento\UrlRewrite\Model\UrlRewriteFactory $urlRewriteFactory,
      \Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory $urlRewriteCollectionFactory,
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
      $this->urlRewrite = $urlRewriteFactory->create();
      $this->urlRewriteCollection = $urlRewriteCollectionFactory->create();
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

    protected function _afterSave(DataObject $object)
    {
      $this->updateUrlRewrite($object);
      parent::_afterSave($object);

    }

    private function updateUser(DataObject & $object)
    {
      if ($object->getUserId()) {
        $this->user->load($object->getUserId());
      }
      $data = $object->getData();
      $active = $object->getIsActive();

      if (!$this->user->isObjectNew()) {
        $this->_productStatusChanged = ($this->user->getIsActive() != $object->getIsActive());
        $this->_usernameChanged = ($this->user->getUsername() != $object->getUsername());
      }

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
      if ($this->_productStatusChanged) {

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

    private function updateUrlRewrite(DataObject $object)
    {
      $vendorId = $object->getEntityId();
      // $this->messageManager->addNotice(urldecode(http_build_query($object->getData()))); 
      
      $urlRewrite = $this->urlRewriteCollection
        ->addFieldToFilter(UrlRewriteService::ENTITY_TYPE, self::ENTITY_TYPE)
        ->addFieldToFilter(UrlRewriteService::ENTITY_ID, $vendorId)
        ->load()->fetchItem();

      if ($urlRewrite) {
        $urlRewrite->delete();
      }
      $this->createNewUrlRewrite($object);
        
      return $this;
    }

    private function createNewUrlRewrite($object)
    {
      $vendorId = $object->getEntityId();

      $this->urlRewrite->setData([
        UrlRewriteService::ENTITY_ID => $vendorId,
        UrlRewriteService::ENTITY_TYPE => self::ENTITY_TYPE,
        UrlRewriteService::IS_AUTOGENERATED => 0,
        UrlRewriteService::REQUEST_PATH => self::REQUEST_PATH_PREFIX . $object->getUsername(),
        UrlRewriteService::TARGET_PATH => self::TARGET_PATH_PREFIX . $vendorId,
        UrlRewriteService::STORE_ID => self::STORE_ID,
        UrlRewriteService::REDIRECT_TYPE => self::REDIRECT_TYPE,
        UrlRewriteService::DESCRIPTION => null,
        UrlRewriteService::METADATA => null
      ]);        
      
      try {
        $this->urlRewrite->save();
      } catch (\Exception $e) {
        $this->messageManager->addException($e);
      }

      return $this;
    }

    protected function _afterDelete(DataObject $object)
    {
      $userId = $object->getUserId();
      $vendorId = $object->getEntityId();
      $this->productCollection->addAttributeToFilter('user_id', $userId)->load()->delete();

      $this->user->load($userId);
      $this->user->delete();

      $vendorUrl = $this->urlRewriteCollection->addFieldToFilter(UrlRewriteService::ENTITY_TYPE, self::ENTITY_TYPE)->addFieldToFilter(UrlRewriteService::ENTITY_ID, $vendorId)->load()->fetchItem();

      if ($vendorUrl) {
          $vendorUrl->delete();
      }

      parent::_afterDelete($object);
    }
  }
