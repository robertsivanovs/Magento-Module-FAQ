<?php

declare(strict_types=1);

/**
 * Delete button in FAQ add/edit form
 */
namespace Learning\Faq\Ui\Component\Form\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Learning\Faq\Api\QuestionRepositoryInterface;

/**
 * Class Delete
 */
class Delete implements ButtonProviderInterface
{

   /**
     * @var Context
     */
    protected $context;

    /**
     * @var QuestionRepositoryInterface
     */
    protected $questionRepositoryInterface;

    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->context = $context;
        $this->questionRepository = $questionRepository;
    }

    /**
     * @inheritDoc
     */
    public function getButtonData(): ?array
    {
        $data = [];
        if ($this->getQuestionId()) {
            $data = [
                'label' => __('Delete Question'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * URL to send delete requests to.
     *
     * @return string
     */
    public function getDeleteUrl(): string
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getQuestionId()]);
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    /**
     * Return Question ID
     *
     * @return int|null
     */
    public function getQuestionId(): ?int
    {
        try {
            return $this->questionRepository->getById(
                (int)$this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }
}
