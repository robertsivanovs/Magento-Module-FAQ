<?php

declare(strict_types=1);

/**
 * Learning FAQ module QuestionRepositoryInterface
 */
namespace Learning\Faq\Api;

/**
 * Learning FAQ CRUD interface.
 */
interface QuestionRepositoryInterface
{
    /**
     * Save question.
     *
     * @param \Learning\Faq\Api\Data\QuestionInterface $question
     * @return \Learning\Faq\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\QuestionInterface $question): \Learning\Faq\Api\Data\QuestionInterface;

    /**
     * Retrieve questions matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Learning\Faq\Api\Data\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
        ):\Learning\Faq\Api\Data\QuestionSearchResultsInterface;

    /**
     * Delete question by ID.
     *
     * @param string|null $questionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(?int $questionId): bool;

    /**
     * Retrieve question
     *
     * @param string|null $id
     * @return \Learning\Faq\Model\Question
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(?int $id): \Learning\Faq\Model\Question;

    /**
     * get
     *
     * Get all FAQ entries
     *
     * @return Learning\Faq\Api\Data\QuestionSearchResultsInterface
     */
    public function get(): \Learning\Faq\Api\Data\QuestionSearchResultsInterface;

}
