<?php

declare(strict_types=1);

/**
 * Interface for Question Management model
 */
namespace Learning\Faq\Api;

/**
 * Interface for mass enable/disable FAQ Questions
 */
interface QuestionManagementInterface
{

    /**
     * Enable question.
     *
     * @param \Magento\Framework\View\Element\UiComponent\DataProvider\Document $question
     * @return boolean
     * @throws CouldNotSaveException
     */
    public function enableQuestion(
        \Magento\Framework\View\Element\UiComponent\DataProvider\Document $question): bool;

    /**
     * Disable question.
     *
     * @param \Magento\Framework\View\Element\UiComponent\DataProvider\Document $question
     * @return boolean
     * @throws CouldNotSaveException
     */
    public function disableQuestion(
        \Magento\Framework\View\Element\UiComponent\DataProvider\Document $question): bool;

}
