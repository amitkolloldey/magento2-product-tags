<?php
namespace Strativ\ProductTags\Controller\Adminhtml\Tag;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{ 
    protected $resultPageFactory;
    
   
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
     
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Strativ_ProductTags::tag_management');
    }
     
    public function execute()
    { 
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Strativ_ProductTags::tag_management');
        $resultPage->addBreadcrumb(__('Product Tags'), __('Product Tags'));
        $resultPage->addBreadcrumb(__('Manage Tags'), __('Manage Tags'));
        $resultPage->getConfig()->getTitle()->prepend(__('Product Tags'));
        
        return $resultPage;
    }
}