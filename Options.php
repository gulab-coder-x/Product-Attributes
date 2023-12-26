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



