<?php

declare(strict_types=1);

/**
 * Interface for Question model
 */
namespace Learning\Faq\Api\Data;

/**
 * Question interface.
 */
interface QuestionInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID            = 'id';
    const QUESTION      = 'question';
    const ANSWER        = 'answer';
    const STATUS        = 'status';
    const POSITION      = 'position';
    const UPDATED_AT    = 'updated_at';
    const TABLE_NAME    = 'learning_faq';
    /**#@-*/

    /**
     * Get ID
     *
     * @return string|null
     */
    public function getId(): ?int;

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion(): string;

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer(): string;

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition(): int;

    /**
     * Get updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Set question
     *
     * @param  string $question
     * @return string
     */
    public function setQuestion(string $question): \Learning\Faq\Api\Data\QuestionInterface;

    /**
     * Set answer
     *
     * @param  string $answer
     * @return string
     */
    public function setAnswer(string $answer): \Learning\Faq\Api\Data\QuestionInterface;

    /**
     * Set status
     *
     * @param  int $status
     * @return \Learning\Faq\Api\Data\QuestionInterface
     */
    public function setStatus(int $status): \Learning\Faq\Api\Data\QuestionInterface;

    /**
     * Set position
     *
     * @param  int $position
     * @return int
     */
    public function setPosition(int $position): \Learning\Faq\Api\Data\QuestionInterface;

}
