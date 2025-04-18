<?php
namespace Strativ\ProductTags\Controller\Adminhtml\Tag;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Strativ\ProductTags\Model\ProductTagFactory;
use Magento\Framework\Registry;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $productTagFactory;
    protected $coreRegistry;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ProductTagFactory $productTagFactory,
        Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->productTagFactory = $productTagFactory;
        $this->coreRegistry = $coreRegistry;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Strativ_ProductTags::tag_management');
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->productTagFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This tag no longer exists.'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }
        }
 
        $this->coreRegistry->register('strativ_tag', $model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Strativ_ProductTags::tag_management');
        $resultPage->getConfig()->getTitle()->prepend($id ? __('Edit Tag') : __('New Tag'));
        
        return $resultPage;
    }
}
