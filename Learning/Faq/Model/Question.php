<?php

declare(strict_types=1);

/**
 * Question Model.
 */
namespace Learning\Faq\Model;
use Learning\Faq\Api\Data\QuestionInterface;

class Question extends \Magento\Framework\Model\AbstractModel implements QuestionInterface
{
    /**
     * FAQ page cache tag.
     */
    const CACHE_TAG = 'learning_faq';

    /**
     * @var string
     */
    protected $_cacheTag = 'learning_faq';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'learning_faq';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(\Learning\Faq\Model\ResourceModel\Question::class);
    }
    /**
     * Get Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->asInt($this->getData(self::ID));
    }

    /**
     * asInt
     *
     * @param  mixed $data
     * @return int|null
     */
    public function asInt($data = null): ?int {

        if (!$data) {
            return null;
        }
        if (gettype($data) != 'integer') {
            settype($data, 'integer');
        }
        return $data;
    }

    /**
     * Get question.
     *
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->getData(self::QUESTION);
    }


    /**
     * setQuestion
     *
     * @param  string $question
     * @return string
     */
    public function setQuestion(string $question): \Learning\Faq\Api\Data\QuestionInterface
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->getData(self::ANSWER);
    }


    /**
     * Set answer
     *
     * @param  string $answer
     * @return string
     */
    public function setAnswer(string $answer): \Learning\Faq\Api\Data\QuestionInterface
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set status.
     *
     * @param  int $status
     * @return \Learning\Faq\Api\Data\QuestionInterface;
     */
    public function setStatus(int $status): \Learning\Faq\Api\Data\QuestionInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->getData(self::POSITION);
    }


    /**
     * Set position.
     *
     * @param  int $position
     * @return int
     */
    public function setPosition(int $position): \Learning\Faq\Api\Data\QuestionInterface
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get updated_at.
     *
     * @return timestamp
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }
}
