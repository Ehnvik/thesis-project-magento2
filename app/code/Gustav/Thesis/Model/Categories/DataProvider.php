<?php

namespace Gustav\Thesis\Model\Categories;

use Gustav\Thesis\Model\ResourceModel\Categories\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\RequestInterface;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var array
     */
    protected array $loadedData = [];

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->request = $request;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $data = parent::getData();

        $categoryId = $this->request->getParam('category_id');
        if ($categoryId) {
            $categoryData = $this->collection->getItemById($categoryId)->getData();
            if ($categoryData) {
                $this->loadedData[$categoryId] = $categoryData;
            }
        }

        return $this->loadedData ?: $data;
    }
}
