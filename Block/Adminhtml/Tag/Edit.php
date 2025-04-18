<?php
namespace Strativ\ProductTags\Block\Adminhtml\Tag;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

class Edit extends Container
{
    protected $_coreRegistry = null;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Strativ_ProductTags';
        $this->_controller = 'adminhtml_tag';
        
        parent::_construct();
        
        $this->buttonList->update('save', 'label', __('Save Tag'));
        $this->buttonList->add(
            'saveandcontinue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            -100
        );
        
        $this->buttonList->update('delete', 'label', __('Delete Tag'));
    }

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('strativ_tag')->getId()) {
            return __("Edit Tag '%1'", $this->escapeHtml($this->_coreRegistry->registry('strativ_tag')->getTag()));
        } else {
            return __('New Tag');
        }
    }

    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'page_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'page_content');
                }
            };
        ";
        
        return parent::_prepareLayout();
    }
}