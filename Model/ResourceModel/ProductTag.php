<?php
namespace Strativ\ProductTags\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductTag extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('strativ_product_tags', 'id');
    }

    public function getTagsByProductId($productId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getMainTable(), ['tag'])
            ->where('product_id = ?', $productId);

        return $connection->fetchCol($select);
    }

    public function saveProductTags($productId, array $tags)
    {
        $connection = $this->getConnection();

        $connection->delete(
            $this->getMainTable(),
            ['product_id = ?' => $productId]
        );

        $data = [];
        foreach ($tags as $tag) {
            $tag = trim($tag);
            if (!empty($tag)) {
                $data[] = [
                    'product_id' => $productId,
                    'tag' => $tag
                ];
            }
        }

        if (!empty($data)) {
            $connection->insertMultiple($this->getMainTable(), $data);
        }
    }
}