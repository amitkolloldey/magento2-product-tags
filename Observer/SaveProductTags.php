<?php
namespace Strativ\ProductTags\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Strativ\ProductTags\Model\ResourceModel\ProductTag as ProductTagResource;

class SaveProductTags implements ObserverInterface
{
    private $productTagResource;

    public function __construct(
        ProductTagResource $productTagResource
    ) {
        $this->productTagResource = $productTagResource;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();

        if ($product && $product->getId()) {
            $tags = $product->getData('strativ_tags');

            if (is_string($tags)) {
                $inputTags = array_map('trim', explode(',', $tags));

                $tagsArray = array_filter($inputTags, function ($tag) {
                    return !empty($tag);
                });

                $uniqueTags = [];
                $uniqueTagsLower = [];

                foreach ($tagsArray as $tag) {
                    $tagLower = strtolower($tag);
                    if (!in_array($tagLower, $uniqueTagsLower)) {
                        $uniqueTags[] = $tag;
                        $uniqueTagsLower[] = $tagLower;
                    }
                }

                if (count($uniqueTags) < count($tagsArray)) {
                    $deduped = implode(', ', $uniqueTags);
                    $product->setData('strativ_tags', $deduped);

                    try {
                        $product->getResource()->saveAttribute($product, 'strativ_tags');
                    } catch (\Exception $e) {
                    }

                    try {
                        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                        $messageManager = $objectManager->get(\Magento\Framework\Message\ManagerInterface::class);
                        $messageManager->addNoticeMessage(__('Duplicate tags were removed.'));
                    } catch (\Exception $e) {
                    }
                }

                $this->productTagResource->saveProductTags($product->getId(), $uniqueTags);
            }
        }
    }
}