<?php

declare(strict_types=1);

 /**
 * Edits clicked entry inline
 */
namespace Learning\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Learning\Faq\Model\ResourceModel\Question\Collection;
use Learning\Faq\Api\QuestionRepositoryInterface;

/**
 * InlineEdit
 */
class InlineEdit extends Action
{
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var Collection
     */
    protected $questionCollection;

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * @param Context     $context
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        QuestionRepositoryInterface $questionRepository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->questionRepository = $questionRepository;
    }

    /**
     * execute
     *
     * @return void
     */
    public function execute()
    {
        /**
         * @var \Magento\Framework\Controller\Result\Json $resultJson
         */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postData = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postData))) {
            return $resultJson->setData(
                [
                    'messages' => [__('Please correct the data which you send.')],
                    'error' => true,
                ]
            );
        }

        foreach (array_keys($postData) as $questionId) {

            /** @var \Learning\Faq\Model\Question $question */
            $question = $this->questionRepository->getById((int)$questionId);
            try {
                $question->setData(array_merge($question->getData(), $postData[$questionId]));
                $this->questionRepository->save($question);
            } catch (\Exception $e) {
                $messages[] = "[ID: {$questionId}]  {$e->getMessage()}";
                $error = true;
            }
        }

        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error,
            ]
        );
    }
}
