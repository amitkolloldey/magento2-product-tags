<?php
namespace Strativ\ProductTags\Controller\Adminhtml\Tag;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Strativ\ProductTags\Model\ProductTagFactory;
use Strativ\ProductTags\Model\ResourceModel\ProductTag\CollectionFactory;

class Save extends Action
{
    protected $productTagFactory;
    protected $collectionFactory;

    public function __construct(
        Context $context,
        ProductTagFactory $productTagFactory,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->productTagFactory = $productTagFactory;
        $this->collectionFactory = $collectionFactory;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Strativ_ProductTags::tag_management');
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $id = $this->getRequest()->getParam('id');
            $model = $this->productTagFactory->create();
            
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This tag no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
             
            $tag = $data['tag'];
            $productId = $data['product_id'];
             
            $existingTag = $this->collectionFactory->create()
                ->addFieldToFilter('tag', $tag)
                ->addFieldToFilter('product_id', $productId);
                
            if ($id) {
                $existingTag->addFieldToFilter('id', ['neq' => $id]);
            }
            
            if ($existingTag->getSize() > 0) {
                $this->messageManager->addErrorMessage(__('A tag with the same name already exists for this product.'));
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
            
            try {
                $model->setData($data);
                $model->save();
                
                $this->messageManager->addSuccessMessage(__('The tag has been saved.'));
                
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        
        return $resultRedirect->setPath('*/*/');
    }
}