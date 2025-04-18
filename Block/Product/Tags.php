<?php
namespace Strativ\ProductTags\Block\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Strativ\ProductTags\Model\ResourceModel\ProductTag as ProductTagResource;

class Tags extends Template
{
    protected $registry;

    protected $productTagResource;


    public function __construct(
        Context $context,
        Registry $registry,
        ProductTagResource $productTagResource,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->productTagResource = $productTagResource;
        parent::__construct($context, $data);
    }

    public function getProduct()
    {
        return $this->registry->registry('current_product');
    }


    public function getProductTags()
    {
        $product = $this->getProduct();
        if ($product && $product->getId()) {
            return $this->productTagResource->getTagsByProductId($product->getId());
        }

        return [];
    }

    public function getTagUrl($tag)
    {
        return $this->getUrl('producttags/tag/view', ['tag' => urlencode($tag)]);
    }
}