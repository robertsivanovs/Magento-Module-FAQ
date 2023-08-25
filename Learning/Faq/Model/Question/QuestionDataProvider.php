<?php

declare(strict_types=1);

/**
 * Data Provider for FAQ question add/edit form fields
 */
namespace Learning\Faq\Model\Question;

use Learning\Faq\Model\ResourceModel\Question\CollectionFactory;
use Learning\Faq\Model\Question;

/**
 * QuestionDataProvider
 */
class QuestionDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $loadedData;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        array $meta = [],
        array $data = []
    ){
        $this->collection = $contactCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * getData
     *
     * Fetches and passes data to FAQ question add/edit form fields
     *
     * @return array
     */
    public function getData(): ?array
    {
        if(isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach($items as $contact)
        {
            $this->loadedData[$contact->getId()] = $contact->getData();
        }

        return $this->loadedData;
    }
}
