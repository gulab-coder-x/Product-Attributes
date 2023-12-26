
<!-- Product toggle Yess/No -->
<?php

namespace Kinex\CustomModule\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
	private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
	}

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Product::ENTITY,'not_for_sale',
			[
				'type' => 'int',
				'backend' => '',
				'frontend' => '',
				'label' => 'Not For Sale',
				'input' => 'boolean',
				'class' => '',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
				'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
				'visible' => true,
				'required' => false,
				'user_defined' => false,
				'default' => 0,
				'searchable' => false,
				'filterable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => true,
				'unique' => false,
				'apply_to' => ''
			]
		);
	}
	
}


<module name="Kinex_CustomModule" setup_version="1.2.0">
<?php

namespace Kinex\CustomModule\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
	}

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		if (version_compare($context->getVersion(), '1.2.0', '<')) {
			$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,'is_discontinued',
                [
                    'type' => 'int',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Is Discontinued',
                    'input' => 'boolean',
                    'class' => '',
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => 0,
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => ''
                ]
            );
		}
	}
}

// Product Input Attribute
<?php
namespace Thecoachsmb\ProductAttribute\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
	private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
	}
	
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Product::ENTITY,
			'sample_attribute',
			[
				'type' => 'text',
				'backend' => '',
				'frontend' => '',
				'label' => 'Sample Atrribute',
				'input' => 'text',
				'class' => '',
				'source' => '',
				'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
				'visible' => true,
				'required' => true,
				'user_defined' => false,
				'default' => '',
				'searchable' => false,
				'filterable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => true,
				'unique' => false,
				'apply_to' => ''
			]
		);
	}
}

// Product Select Option Attribute
<?php
namespace Kinex\ProductLabel\Setup;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class InstallData implements InstallDataInterface
{
	private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
	}
	
	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Product::ENTITY,
			'product_flag',
			[
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Product Flag',
                'input' => 'select',
                'class' => '',
                'source' => \Kinex\ProductLabel\Model\ProductLabel\Source\Config\Options::class,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => ' ',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
		);
	}
}


<?php
namespace Kinex\ProductLabel\Model\ProductLabel\Source\Config;
class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    
    protected $_productLabel;
    public function __construct(\Kinex\ProductLabel\Model\ResourceModel\Grid\CollectionFactory $productLabelFactory)
    {
        $this->_productLabel= $productLabelFactory;
    }
  for dynamic options
    // public function getAllOptions(): array
    // {
    //     $availableOptions=$this->_productLabel->create();
    //     $options=[];
    //     $options[]=['label' => __('No Label'),'value' => 0];
       
    //     foreach($availableOptions as $value)
    //     {
    //             $options[]=
    //             [
    //                 'label' => __($value['image_label']),
    //                 'value' => $value['entity_id'],
    //             ];
    //     }
    //     return $options;
    // }
       for static options
   // public function getAllOptions()
   //  {
   //      $this->_options = [
   //              ['label' => __('No'), 'value'=>'0'],
   //              ['label' => __('Yes'), 'value'=>'1'],
   //              ['label' => __('Other'), 'value'=>'2']
   //          ];

   //  return $this->_options;

   //  }
}
