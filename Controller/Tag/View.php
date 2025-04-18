<?php
namespace Strativ\ProductTags\Controller\Tag;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory; 

class View implements HttpGetActionInterface
{ 
    private $request;
 
    private $resultPageFactory;
 
    public function __construct(
        RequestInterface $request,
        PageFactory $resultPageFactory
    ) {
        $this->request = $request;
        $this->resultPageFactory = $resultPageFactory;
    }
 
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $tag = $this->request->getParam('tag'); 
 
        $resultPage->getConfig()->getTitle()->set(__('Products tagged with "%1"', $tag));

        return $resultPage;
    }
}