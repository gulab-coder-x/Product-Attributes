<?php
 
namespace Kinex\CustomApi\Setup;
 
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
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
        $setup->startSetup();
 
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
 
        /* Remove Category Attribute */
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'custom_select_options');
 
        /* Add Category Attribute */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Category::ENTITY,
            'custom_select_options',
            [
                'type' => 'varchar',
                'label' => 'Custom Select Options',
                'input' => 'multiselect',
                'visible' => true,
                'required' => false,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'group' => 'General Information',
            ]
        );
 
        $setup->endSetup();
    }
}

<?php

namespace Kinex\CustomApi\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class CustomOptionList extends AbstractSource
{

    public function getOptionArray()
    {
        $options = [];
        $options[0] = (__('Option 1'));
        $options[1] = (__('Option 2'));
        $options[2] = (__('Option 3'));
        return $options;
    }

    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }

    public function toOptionArray()
    {
        return $this->getOptions();
    }
}


view/adminhtml/ui_component/category_form.xml
<?xml version="1.0" encoding="UTF-8"?>
<!-- <form xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">
    <fieldset name="general">
        <field name="custom_select_options">
            <argument name="data" xsi:type="array">
                <item name="options" xsi:type="object">Kinex\CustomApi\Model\Config\Source\CustomOptionList</item>
                <item name="config" xsi:type="array">
                    <item name="label" xsi:type="string" translate="true">Custom Option</item>
                    <item name="visible" xsi:type="boolean">true</item>
                    <item name="dataType" xsi:type="string">text</item>
                    <item name="formElement" xsi:type="string">select</item>
                    <item name="source" xsi:type="string">custom_select_options</item>
                    <item name="dataScope" xsi:type="string">custom_select_options</item>
                    <item name="sortOrder" xsi:type="number">20</item>
                </item>
            </argument>
        </field>
    </fieldset>
</form> -->
search select input by using the below code.
<form xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">
      <fieldset name="general">
<field name="custom_toggle">
    <argument name="data" xsi:type="array">
        <item name="options" xsi:type="object">Kinex\CustomApi\Model\Config\Source\CustomOptionList</item>
        <item name="config" xsi:type="array">
            <item name="dataType" xsi:type="string">text</item>
            <item name="filterOptions" xsi:type="boolean">true</item>
            <item name="chipsEnabled" xsi:type="boolean">true</item>
            <item name="label" xsi:type="string">Custom Select</item>
            <item name="disableLabel" xsi:type="boolean">true</item>
            <item name="component" xsi:type="string">Magento_Catalog/js/components/new-category</item>
            <item name="formElement" xsi:type="string">multiselect</item>
            <item name="levelsVisibility" xsi:type="number">1</item>
             <item name="multiple" xsi:type="boolean">false</item>
            <item name="elementTmpl" xsi:type="string">ui/grid/filters/elements/ui-select</item>
            <item name="sortOrder" xsi:type="number">30</item>
            <item name="validation" xsi:type="array">
                <item name="required-entry" xsi:type="boolean">true</item>
            </item>
            <item name="config" xsi:type="array">
                <item name="dataScope" xsi:type="string">custom_toggle</item>
            </item>
        </item>
    </argument>
</field>
 </fieldset>
</form>

<!-- Category Toggle ON/OFF Attribute -->
<?php
 
namespace Kinex\CustomApi\Setup;
 
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
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
        $setup->startSetup();
 
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
 
        /* Remove Category Attribute */
        $eavSetup->removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'custom_select_options');
 
        /* Add Category Attribute */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'in_store',
                [
                    'type'  => 'int',
                    'label' => 'In Store',
                    'input' => 'boolean',
                    'sort_order'   => 100,
                    'source'       =>\Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'global' =>     \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                    'visible'      => true,
                    'required'     => false,
                    'user_defined' => false,
                    'default'      => 0,
                    'group'        => '',
                    'backend'      => ''
                ]
            );
 
        $setup->endSetup();
    }
}


// view/adminhtml/ui_component/category_form.xml
<form xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">
    <fieldset name="general">
        <field name="in_store" sortOrder="20" formElement="checkbox">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="source" xsi:type="string">category</item>
                    <item name="default" xsi:type="number">0</item>
                </item>
            </argument>
            <settings>
                <validation>
                    <rule name="required-entry" xsi:type="boolean">false</rule>
                </validation>
                <dataType>boolean</dataType>
                <label translate="true">In Store Material</label>
            </settings>
            <formElements>
                <checkbox>
                    <settings>
                        <valueMap>
                            <map name="false" xsi:type="string">0</map>
                            <map name="true" xsi:type="string">1</map>
                        </valueMap>
                        <prefer>toggle</prefer>
                    </settings>
                </checkbox>
            </formElements>
        </field>
    </fieldset>
</form>

 // Category Attribute Programmatically
<?php
namespace Mageplaza\HelloWorld\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{

	private $eavSetupFactory;

	public function __construct(EavSetupFactory $eavSetupFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
	}

	public function install(
		ModuleDataSetupInterface $setup,
		ModuleContextInterface $context
	)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Category::ENTITY,
			'mp_new_attribute',
			[
				'type'         => 'varchar',
				'label'        => 'Mageplaza Attribute',
				'input'        => 'text',
				'sort_order'   => 100,
				'source'       => '',
				'global'       => 1,
				'visible'      => true,
				'required'     => false,
				'user_defined' => false,
				'default'      => null,
				'group'        => '',
				'backend'      => ''
			]
		);
	}
}


// view/adminhtml/ui_component/category_form.xml
<?xml version="1.0" ?>
<form xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">
    <fieldset name="general">
        <field name="mp_new_attribute">
            <argument name="data" xsi:type="array">
                <item name="config" xsi:type="array">
                    <item name="required" xsi:type="boolean">false</item>
                    <item name="validation" xsi:type="array">
                        <item name="required-entry" xsi:type="boolean">false</item>
                    </item>
                    <item name="sortOrder" xsi:type="number">333</item>
                    <item name="dataType" xsi:type="string">string</item>
                    <item name="formElement" xsi:type="string">input</item>
                    <item name="label" translate="true" xsi:type="string">Mageplaza new attribute</item>
                </item>
            </argument>
        </field>
    </fieldset>
</form>
