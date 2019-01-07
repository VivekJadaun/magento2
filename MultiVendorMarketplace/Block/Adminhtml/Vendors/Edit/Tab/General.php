<?php
  namespace Vinsol\MultiVendorMarketplace\Block\Adminhtml\Vendors\Edit\Tab;

  /**
   * 
   */
  class General extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface 
	{
		protected $wysiwygConfig;
		protected $vendor;
		protected $roles;
		public function __construct(
			\Magento\Backend\Block\Template\Context $context,
			\Magento\Framework\Registry $registry,
			\Magento\Framework\Data\FormFactory $formFactory,
			\Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
			\Vinsol\MultiVendorMarketplace\Model\VendorFactory $vendorFactory,
			\Vinsol\MultiVendorMarketplace\Model\Config\Source\Roles $roles,
			array $data = []
		) { 
			$this->wysiwygConfig = $wysiwygConfig;
			$this->vendor = $vendorFactory->create();
			$this->roles = $roles->toOptionArray();
			parent::__construct($context, $registry, $formFactory, $data);
		}

		protected function _prepareForm()
		{
			$model = $this->_coreRegistry->registry('vendor');
			$form = $this->_formFactory->create();

			$fieldset = $form->addFieldset(
				'base_fieldset',
				['legend' => __('General')]
			);

			if ($model->getId()) {
				$fieldset->addField('id', 'hidden', ['name' => 'id']);
			}

			$fieldset->addField(
				'firstname',
				'text',
				[
					'name' => 'firstname',
					'label' => __('Firstname'),
					'required' => true
				]
			);

			$fieldset->addField(
				'lastname',
				'text',
				[
					'name' => 'lastname',
					'label' => __('Lastname'),
					'required' => true
				]
			);

			$fieldset->addField(
				'email',
				'text',
				[
					'name' => 'email',
					'label' => __('Email ID'),
					'required' => true
				]
			);      

			$fieldset->addField(
				'username',
				'text',
				[
					'name' => 'username',
					'label' => __('Username'),
					'required' => true
				]
			);

			$fieldset->addField(
				'password',
				'password',
				[
					'name' => 'password',
					'label' => __('Password'),
					'required' => true
				]
			); 

			$fieldset->addField(
				'role_id',
				'select',
				[
					'name' => 'role_id',
					'label' => __('Role'),
					'required' => true,
					'values' => $this->roles
				]
			); 

			$fieldset->addField(
				'is_active',
				'select',
				[
					'name' => 'is_active',
					'label' => __('Active'),
					'required' => true,
					'values' => [
						['value'=>"1",'label'=>__('Yes')],
						['value'=>"0",'label'=>__('No')]
					]
				]
			);

			$fieldset->addField(
				'commission',
				'text',
				[
					'name' => 'commission',
					'label' => __('Commission (in %)'),
					'required' => true
				]
			);

			$fieldset->addField(
				'contact_no',
				'text',
				[
					'name' => 'contact_no',
					'label' => __('Contact number'),
					'required' => true
				]
			);

			$fieldset->addField(
				'sort_order',
				'text',
				[
					'name' => 'sort_order',
					'label' => __('Sort Order'),
					'required' => false,
					'value' => '0'
				]
			);

			$fieldset->addField(
				'address',
				'textarea',
				[
					'name' => 'address',
					'label' => __('Address'),
					'required' => false,
					'style' => 'height: 10em; width: 100%;',
					'config' => $this->wysiwygConfig->getConfig()
				]
			);     


			// $fieldset->addField(
			// 	'logo',
			// 	'file',
			// 	[
			// 		'name' => 'logo',
			// 		'label' => __('Logo'),
			// 		'required' => false
			// 	]
			// ); 

			// $fieldset->addField(
			// 	'banner',
			// 	'file',
			// 	[
			// 		'name' => 'banner',
			// 		'label' => __('Banner'),
			// 		'required' => false
			// 	]
			// ); 

			$data = $model->getData();
			$form->setValues($data);
			$this->setForm($form);

			return parent::_prepareForm();

		}

		public function getTabLabel(){
			return __('Vendor');
		}
		public function getTabTitle(){
			return __('Vendor');
		}
		public function canShowTab(){
			return true;
		}
		public function isHidden(){
			return false;
		}
	}