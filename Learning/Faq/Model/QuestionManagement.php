<?php

declare(strict_types=1);

/**
 * Management model for FAQ Questions
 */
namespace Learning\Faq\Model;

use Learning\Faq\Api\QuestionManagementInterface;
use Learning\Faq\Api\QuestionRepositoryInterface;
use Learning\Faq\Model\ResourceModel\Question as ResourceQuestion;

/**
 * Class for management of FAQ Questions
 */
class QuestionManagement implements QuestionManagementInterface
{
    /**
     * Cart total repository.
     *
     * @var QuestionRepositoryInterface
     */
    protected $QuestionRepositoryInterface;

    /**
     * @var ResourceQuestion
     */
    protected $resource;

    /**
     * __construct
     * @param QuestionRepositoryInterface $questionRepository
     * @return void
     */
    public function __construct(
        QuestionRepositoryInterface $questionRepository,
        ResourceQuestion $resource
    )
    {
        $this->resource = $resource;
        $this->questionRepository = $questionRepository;
    }

    /**
     * enableQuestion
     *
     * Enables FAQ Question (sets status to 1)
     *
     * @param  \Magento\Framework\View\Element\UiComponent\DataProvider\Document $questionData
     * @return boolean
     */
    public function enableQuestion (
        \Magento\Framework\View\Element\UiComponent\DataProvider\Document $questionData): bool {

        $question = $this->questionRepository->getById((int)$questionData->getId());
        $result = false;

        try {
            $question->setStatus(1);
            if ($this->resource->save($question)) {
                $result = true;
            }
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $result;
    }

    /**
     * disableQuestion
     *
     * Disables FAQ Question (sets status to 0)
     *
     * @param  \Magento\Framework\View\Element\UiComponent\DataProvider\Document $questionData
     * @return boolean
     */
    public function disableQuestion (
        \Magento\Framework\View\Element\UiComponent\DataProvider\Document $questionData): bool  {

        $question = $this->questionRepository->getById((int)$questionData->getId());
        $result = false;

        try {
            $question->setStatus(0);
            if ($this->resource->save($question)) {
                $result = true;
            }
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $result;

    }
}
