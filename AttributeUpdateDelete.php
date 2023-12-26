<?php

namespace Dolphin\CategoryAttribute\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.2') < 0) {

            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            /* For Remove Attribute */
            $eavSetup->removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'ATTRIBUTE_CODE');

            /* For Create New Attribute */
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'ATTRIBUTE_CODE',
                [
                    'type' => 'varchar',
                    'label' => 'Updated Attribute Name',
                    'input' => 'text',
                    'required' => false,
                    'sort_order' => 35,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'wysiwyg_enabled' => true,
                    'group' => 'General Information',
                ]
            );

            /* For Update Attribute */
            $eavSetup->updateAttribute(\Magento\Catalog\Model\Category::ENTITY, 'ATTRIBUTE_CODE', 'position', 100);
        }
        $setup->endSetup();
    }
}


// method 2
<?php
namespace Kinex\CustomApi\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.9') < 0) {

            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
           
            /* For Update Attribute */
            // $newLabel = 'custom_ttribute';
            // $eavSetup->updateAttribute(
            //     \Magento\Catalog\Model\Product::ENTITY,
            //     'sample_attribute',
            //     'attribute_code',-->column name from database->it also change attribute code name
            //     $newLabel
            // );
                        /* For Remove Attribute */
                $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'custom_ttribute');

        }
        $setup->endSetup();
    }
}
