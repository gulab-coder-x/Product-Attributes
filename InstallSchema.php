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

    public function getAllOptions(): array
    {
        $availableOptions=$this->_productLabel->create();
        $options=[];
        $options[]=['label' => __('No Label'),'value' => 0];
       
        foreach($availableOptions as $value)
        {
                $options[]=
                [
                    'label' => __($value['image_label']),
                    'value' => $value['entity_id'],
                ];
        }
        return $options;
    }
}
