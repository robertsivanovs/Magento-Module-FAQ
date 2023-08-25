<?php

declare(strict_types=1);

/**
 * Saves question data
 */
namespace Learning\Faq\Controller\Adminhtml\Question;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Learning\Faq\Api\QuestionRepositoryInterface;
use Learning\Faq\Api\Data\QuestionInterfaceFactory;

/**
 * Class Save
 */
class Save extends Action
{
    protected $request;
    protected $resultRedirectFactory;
    protected $jsonHelper;
    protected $date;
    protected $questionRepository;
    protected $questionFactory;

    /**
     * __construct
     *
     * @param  mixed $context
     * @param  mixed $jsonHelper
     * @param  mixed $date
     * @param  QuestionRepositoryInterface $questionRepository
     * @param  QuestionInterfaceFactory $questionFactory
     * @return void
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        QuestionRepositoryInterface $questionRepository,
        QuestionInterfaceFactory $questionFactory
        )
    {
        $this->jsonHelper = $jsonHelper;
        $this->date = $date;
        $this->questionRepository = $questionRepository;
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

    /**
     * execute
     *
     * Saves Question POST Data to DB
     *
     * @return void
     */
    public function execute() {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        try {
            $id = (int)$this->getRequest()->getParam('id');
            $date = $this->date->gmtDate();
            $postData = array(
                'question' => $data['question'],
                'answer' => $data['answer'],
                'status' => $data['status'],
                'updated_at' => $date
            );
            if($id) {
                $question = $this->questionRepository->getById($id);
                $question->setQuestion($postData['question']);
                $question->setAnswer($postData['answer']);
                $question->setStatus((int)$postData['status']);
                $question->setUpdatedAt($postData['updated_at']);
            }
            else {
                $question = $this->questionFactory->create();
                $question->setData($postData);
            }

            $this->questionRepository->save($question);
            $this->messageManager->addSuccessMessage(__('The Question has been saved.'));

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(nl2br($e->getMessage()));
            return $resultRedirect->setPath('*/*/index');
        }
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/index', ['id' => $id, '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/index');
    }
}
