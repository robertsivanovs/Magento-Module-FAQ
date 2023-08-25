<?php

declare(strict_types=1);

/**
 * Model for QuestionRepositoryInterface
 */
namespace Learning\Faq\Model;

use Learning\Faq\Api\QuestionRepositoryInterface;
use Learning\Faq\Api\Data;
use Learning\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Learning\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\App\ObjectManager;
use \Magento\Framework\Api\SearchCriteriaInterface;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Framework\Api\FilterBuilder;
use \Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use \Learning\Faq\Api\Data\QuestionSearchResultsInterfaceFactory;

/**
 * QuestionRepository
 */
class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var ResourceQuestion
     */
    protected $resource;

    /**
     * @var QuestionFactory
     */
    protected $questionFactory;

    /**
     * @var QuestionCollectionFactory
     */
    protected $questionCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    /**
     * @var QuestionSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var SearchCriteriaInterface
     */
    protected $criteria;

    /**
     * @var FilterGroup
     */
    protected $filterGroup;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @param ResourceQuestion $resource
     * @param QuestionFactory $questionFactory
     * @param QuestionCollectionFactory $questionCollectionFactory
     * @param SearchCriteriaInterface $criteria
     * @param FilterGroup $filterGroup
     * @param FilterBuilder $filterBuilder
     * @param CollectionProcessorInterface $collectionProcessor
     * @param QuestionSearchResultsInterfaceFactory $searchResultsFactory
     */

    public function __construct(
        ResourceQuestion $resource,
        QuestionFactory $questionFactory,
        questionCollectionFactory $questionCollectionFactory,
        SearchCriteriaInterface $criteria,
        FilterGroup $filterGroup,
        FilterBuilder $filterBuilder,
        CollectionProcessorInterface $collectionProcessor = null,
        QuestionSearchResultsInterfaceFactory $searchResultsFactory

    ) {
        $this->resource = $resource;
        $this->questionFactory = $questionFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;

        $this->searchCriteria = $criteria;
        $this->filterGroup = $filterGroup;
        $this->filterBuilder = $filterBuilder;
        $this->collectionProcessor ?: $this->getCollectionProcessor();
        $this->searchResultsFactory = $searchResultsFactory;

    }

    /**
     * Save Question data
     *
     * @param \Learning\Faq\Api\Data\QuestionInterface $question
     * @return \Learning\Faq\Api\Data\QuestionInterface $question
     * @throws CouldNotSaveException
     */
    public function save(Data\QuestionInterface $question): \Learning\Faq\Api\Data\QuestionInterface
    {
        try {
            $this->resource->save($question);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $question;
    }

    /**
     * Load Question data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Learning\Faq\Api\Data\QuestionSearchResultsInterface
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
        ): \Learning\Faq\Api\Data\QuestionSearchResultsInterface
    {
        /** @var \Learning\Faq\Model\ResourceModel\Question\Collection $collection */
        $collection = $this->questionCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var Data\QuestionSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete question by given question Identity
     *
     * @param string|null $questionId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(?int $questionId): bool
    {

        $question = $this->getById((int) $questionId);

        try {
            $this->resource->delete($question);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;

        // return $this->delete($this->getById((int) $questionId));
    }

    /**
     * Load Question data by given Question Identity
     *
     * @param string|null $id
     * @return \Learning\Faq\Model\Question
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(?int $id): \Learning\Faq\Model\Question
    {
        $question = $this->questionFactory->create();

        if (!$id) {
            return $question;
        }

        $this->resource->load($question, $id);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('The Question with the "%1" ID doesn\'t exist.', $id));
        }

        return $question;
    }

    /**
     * get
     *
     * Get all FAQ entries that have been enabled (status set to 1)
     *
     * @return Learning\Faq\Api\Data\QuestionSearchResultsInterface
     */
    public function get(): \Learning\Faq\Api\Data\QuestionSearchResultsInterface
    {
        $this->filterGroup->setFilters([
            $this->filterBuilder
                ->setField('status')
                ->setValue('1')
                ->setConditionType('eq')
                ->create()
        ]);

        $this->searchCriteria->setFilterGroups([$this->filterGroup]);
        $questions = $this->getList($this->searchCriteria);
        return $questions;

    }

    /**
     * Retrieve collection processor
     *
     * @deprecated 101.0.0
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = \Magento\Framework\App\ObjectManager::getInstance()->get(
                CollectionProcessor::class
            );
        }
        return $this->collectionProcessor;
    }

}
