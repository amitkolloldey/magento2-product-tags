<?php
namespace Strativ\ProductTags\Controller\Adminhtml\Tag;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Strativ\ProductTags\Model\ProductTagFactory;

class Delete extends Action
{
    protected $productTagFactory;
    
    public function __construct(
        Context $context,
        ProductTagFactory $productTagFactory
    ) {
        parent::__construct($context);
        $this->productTagFactory = $productTagFactory;
    }
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Strativ_ProductTags::tag_management');
    }
    
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        
        if ($id) {
            try {
                $model = $this->productTagFactory->create();
                $model->load($id);
                $model->delete();
                
                $this->messageManager->addSuccessMessage(__('The tag has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        
        $this->messageManager->addErrorMessage(__('We can\'t find a tag to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}