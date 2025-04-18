<?php
namespace Strativ\ProductTags\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Stdlib\ArrayManager;
use Strativ\ProductTags\Model\ResourceModel\ProductTag as ProductTagResource;

class Tags extends AbstractModifier
{ 
    private $arrayManager;
     
    private $productTagResource;
    
 
    public function __construct(
        ArrayManager $arrayManager,
        ProductTagResource $productTagResource
    ) {
        $this->arrayManager = $arrayManager;
        $this->productTagResource = $productTagResource;
    }
     
    public function modifyMeta(array $meta)
    {
        return $meta;
    }
     
    public function modifyData(array $data)
    {
        foreach ($data as $productId => &$productData) {
            if (is_numeric($productId)) {
                $tags = $this->productTagResource->getTagsByProductId($productId);
                if (!empty($tags)) {
                    $path = $this->arrayManager->findPath('product', $productData, null)
                        . '/' . 'strativ_tags';
                    $productData = $this->arrayManager->set(
                        $path,
                        $productData,
                        implode(', ', $tags)
                    );
                }
            }
        }
        
        return $data;
    }
}