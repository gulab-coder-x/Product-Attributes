<?php
namespace Eav\Example\Setup;

use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    protected $eavConfig;
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);



        //creating a custom text field programmatically

        // $eavSetup->addAttribute(
        //     \Magento\Customer\Model\Customer::ENTITY,
        //     'custom_text_field',
        //     [
        //         'label' => 'Middle Name',
        //         'system' => 0,
        //         'position' => 700,
        //         'sort_order' => 700,
        //         'visible' => true,
        //         'note' => '',
        //         'type' => 'varchar',
        //         'input' => 'text',
        //     ]
        // );

        // $this->getEavConfig()->getAttribute('customer', 'custom_text_field')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'checkout_register', 'customer_account_create', 'customer_account_edit', 'adminhtml_checkout'])->save();



        //magento 2 create customer dropdown attribute programmatically

        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'custom_dropdown',
            [
                'label' => 'How did you hear about us?',
                'system' => 0,
                'position' => 700,
                'sort_order' => 700,
                'visible' => true,
                'note' => '',
                'type' => 'int',
                'input' => 'select',
                'source' => 'Eav\Example\Model\Source\Customdropdown',
            ]
        );

        $this->getEavConfig()->getAttribute('customer', 'custom_dropdown')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'checkout_register', 'customer_account_create', 'customer_account_edit', 'adminhtml_checkout'])->save();



        //magento 2 create yes/no customer attribute programmatically

        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'custom_yes_no',
            [
                'label' => 'Are you an existing customer?',
                'system' => 0,
                'position' => 700,
                'sort_order' => 700,
                'visible' => true,
                'note' => '',
                'type' => 'int',
                'input' => 'boolean',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            ]
        );

        $this->getEavConfig()->getAttribute('customer', 'custom_yes_no')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'checkout_register', 'customer_account_create', 'customer_account_edit', 'adminhtml_checkout'])->save();
    }

    public function getEavConfig()
    {
        return $this->eavConfig;
    }
}


<?php
namespace Eav\Example\Model\Source;

class Customdropdown extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        if ($this->_options === null) {

            $this->_options = [

                ['value' => '', 'label' => __('Please Select')],

                ['value' => '1', 'label' => __('Google')],

                ['value' => '2', 'label' => __('Friend')],

                ['value' => '3', 'label' => __('Social Media')],

                ['value' => '3', 'label' => __('Email')],

                ['value' => '4', 'label' => __('Other')]

            ];
        }

        return $this->_options;
    }

    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}



// Customer File Attribute
<?php
/**
* Copyright © Magento, Inc. All rights reserved.
* See COPYING.txt for license details.
*/

/**
 * Created By : Rohan Hapani
 */
declare (strict_types = 1);

namespace Kinex\EditForm\Setup\Patch\Data;

use Magento\Catalog\Ui\DataProvider\Product\ProductCollectionFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CustomerAttribute for Create Customer Attribute using Data Patch.
 * @package RH\Helloworld\Setup\Patch\Data
 */
class CustomerAttribute implements DataPatchInterface, PatchRevertableInterface
{
   /**
    * @var ModuleDataSetupInterface
    */
   private $moduleDataSetup;

   /**
    * @var EavSetupFactory
    */
   private $eavSetupFactory;
   
   /**
    * @var ProductCollectionFactory
    */
   private $productCollectionFactory;
   
   /**
    * @var LoggerInterface
    */
   private $logger;
   
   /**
    * @var Config
    */
   private $eavConfig;
   
   /**
    * @var \Magento\Customer\Model\ResourceModel\Attribute
    */
   private $attributeResource;

   /**
    * CustomerAttribute Constructor
    * @param EavSetupFactory $eavSetupFactory
    * @param Config $eavConfig
    * @param LoggerInterface $logger
    * @param \Magento\Customer\Model\ResourceModel\Attribute $attributeResource
    * @param \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
    */
   public function __construct(
       EavSetupFactory $eavSetupFactory,
       Config $eavConfig,
       LoggerInterface $logger,
       \Magento\Customer\Model\ResourceModel\Attribute $attributeResource,
       \Magento\Framework\Setup\ModuleDataSetupInterface $moduleDataSetup
   ) {
       $this->eavSetupFactory = $eavSetupFactory;
       $this->eavConfig = $eavConfig;
       $this->logger = $logger;
       $this->attributeResource = $attributeResource;
       $this->moduleDataSetup = $moduleDataSetup;
   }

   /**
    * {@inheritdoc}
    */
   public function apply()
   {
       $this->moduleDataSetup->getConnection()->startSetup();
       $this->addPhoneAttribute();
       $this->moduleDataSetup->getConnection()->endSetup();
   }

   /**
    * @throws \Magento\Framework\Exception\AlreadyExistsException
    * @throws \Magento\Framework\Exception\LocalizedException
    * @throws \Zend_Validate_Exception
    */
   public function addPhoneAttribute()
   {
       $eavSetup = $this->eavSetupFactory->create();
       $eavSetup->addAttribute(
           \Magento\Customer\Model\Customer::ENTITY,
           'customer_image',
           [
               'type' => 'text',
               'label' => 'Customer File/Image',
               'input' => 'file',
               'source' => '',
               'required' => false,
               'visible' => true,
               'position' => 200,
               'system' => false,
               'backend' => ''
           ]
       );

       $attributeSetId = $eavSetup->getDefaultAttributeSetId(Customer::ENTITY);
       $attributeGroupId = $eavSetup->getDefaultAttributeGroupId(Customer::ENTITY);

       $attribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'customer_image');
       $attribute->setData('attribute_set_id', $attributeSetId);
       $attribute->setData('attribute_group_id', $attributeGroupId);

       $attribute->setData('used_in_forms', [
           'adminhtml_customer',
           'adminhtml_customer_address',
           'customer_account_edit',
           'customer_address_edit',
           'customer_register_address',
           'customer_account_create'
       ]);

       $this->attributeResource->save($attribute);
   }

   /**
    * {@inheritdoc}
    */
   public static function getDependencies()
   {
       return [];
   }

   /**
    *
    */
   public function revert()
   {
   }

   /**
    * {@inheritdoc}
    */
   public function getAliases()
   {
       return [];
   }
}


extension_attributes.xml
<?xml version="1.0" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Api/etc/extension_attributes.xsd">
    <extension_attributes for="Magento\Customer\Api\Data\CustomerInterface">
        <attribute code="customer_image" type="file"/>
    </extension_attributes>
</config>
