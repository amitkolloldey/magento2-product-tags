<?php
namespace Strativ\ProductTags\Block\Tag;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\RequestInterface;
use Strativ\ProductTags\Model\ResourceModel\ProductTag\Collection as TagCollection;

class ProductList extends Template
{
    protected $request;

    protected $productCollectionFactory;

    protected $tagCollection;

    public function __construct(
        Context $context,
        RequestInterface $request,
        CollectionFactory $productCollectionFactory,
        TagCollection $tagCollection,
        array $data = []
    ) {
        $this->request = $request;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->tagCollection = $tagCollection;
        parent::__construct($context, $data);
    }
    public function getCurrentTag()
    {
        return $this->request->getParam('tag');
    }

    public function getProductCollection()
    {
        $tag = $this->getCurrentTag();
        if (!$tag) {
            return null;
        }
        $productIds = $this->tagCollection->clear()
            ->addTagFilter($tag)
            ->getColumnValues('product_id');

        if (empty($productIds)) {
            return null;
        }

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*')
            ->addAttributeToFilter('entity_id', ['in' => $productIds])
            ->addAttributeToFilter('visibility', ['neq' => 1])
            ->addAttributeToFilter('status', 1);

        return $collection;
    }

    public function getProductImageUrl($product)
    {
        try {
            if ($product->getImage() && $product->getImage() != 'no_selection') {
                $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                return $mediaUrl . 'catalog/product' . $product->getImage();
            }

            if ($product->getSmallImage() && $product->getSmallImage() != 'no_selection') {
                $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                return $mediaUrl . 'catalog/product' . $product->getSmallImage();
            }

            if ($product->getThumbnail() && $product->getThumbnail() != 'no_selection') {
                $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                return $mediaUrl . 'catalog/product' . $product->getThumbnail();
            }

            return $this->getViewFileUrl('Magento_Catalog::images/product/placeholder/image.jpg');
        } catch (\Exception $e) {
            return $this->getViewFileUrl('Magento_Catalog::images/product/placeholder/image.jpg');
        }
    }
    public function formatPrice($price)
    {
        return $this->_storeManager->getStore()->getBaseCurrency()->formatPrecision(
            $price,
            2,
            [],
            false
        );
    }
}