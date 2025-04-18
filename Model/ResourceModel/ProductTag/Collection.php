<?php
namespace Strativ\ProductTags\Model\ResourceModel\ProductTag;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Strativ\ProductTags\Model\ProductTag;
use Strativ\ProductTags\Model\ResourceModel\ProductTag as ResourceModel;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(ProductTag::class, ResourceModel::class);
    }

    public function addProductFilter($productId)
    {
        $this->addFieldToFilter('product_id', $productId);
        return $this;
    }


    public function addTagFilter($tag)
    {
        $tag = urldecode($tag);

        $this->addFieldToFilter('tag', $tag);
        return $this;
    }

    public function getProductIdsByTag($tag)
    {
        $this->addTagFilter($tag);
        return $this->getColumnValues('product_id');
    }
}