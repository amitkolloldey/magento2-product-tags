<?php
namespace Strativ\ProductTags\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class TagActions extends Column
{
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['id'])) {
                    $viewUrl = $this->urlBuilder->getUrl(
                        'catalog/product/edit',
                        ['id' => $item['product_id']]
                    );

                    $deleteUrl = $this->urlBuilder->getUrl(
                        'strativ_producttags/tag/delete',
                        ['id' => $item['id']]
                    );

                    $editUrl = $this->urlBuilder->getUrl(
                        'strativ_producttags/tag/edit',
                        ['id' => $item['id']]
                    );

                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $editUrl,
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $deleteUrl,
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete tag"'),
                                'message' => __('Are you sure you want to delete the tag?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}