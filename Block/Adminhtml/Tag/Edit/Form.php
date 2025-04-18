<?php
namespace Strativ\ProductTags\Block\Adminhtml\Tag\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

class Form extends Generic
{
    protected $productCollectionFactory;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        ProductCollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('strativ_tag');
        
        $form = $this->_formFactory->create([
            'data' => [
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post'
            ]
        ]);
        
        $form->setHtmlIdPrefix('tag_');
        
        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Tag Information')]
        );
        
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }
        
        $fieldset->addField(
            'product_id',
            'select',
            [
                'name' => 'product_id',
                'label' => __('Product'),
                'title' => __('Product'),
                'required' => true,
                'values' => $this->getProductOptions()
            ]
        );
        
        $fieldset->addField(
            'tag',
            'text',
            [
                'name' => 'tag',
                'label' => __('Tag'),
                'title' => __('Tag'),
                'required' => true,
                'class' => 'validate-no-html-tags'
            ]
        );
        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        
        return parent::_prepareForm();
    }
    
    private function getProductOptions()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(['name']);
        
        $options = [];
        $options[] = ['value' => '', 'label' => __('-- Please Select --')];
        
        foreach ($collection as $product) {
            $options[] = [
                'value' => $product->getId(),
                'label' => $product->getName() . ' (' . $product->getSku() . ')'
            ];
        }
        
        return $options;
    }
}