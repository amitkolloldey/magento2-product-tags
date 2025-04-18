<?php
namespace Strativ\ProductTags\Model;

use Magento\Framework\Model\AbstractModel;
use Strativ\ProductTags\Model\ResourceModel\ProductTag as ResourceModel;

class ProductTag extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}