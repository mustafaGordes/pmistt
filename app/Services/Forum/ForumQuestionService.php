<?php

namespace App\Services\Forum;

use App\Repositories\Forum\ForumAnswerRepository;
use App\Repositories\Forum\ForumAnswerRepositoryInterface;
use App\Repositories\Forum\ForumQuestionRepository;
use App\Repositories\Forum\ForumQuestionRepositoryInterface;

class ForumQuestionService
{
    private $forumQuestionRepository;
    private $forumAnswerRepository;

    public function __construct(
        ForumQuestionRepository $forumQuestionRepository,
        ForumAnswerRepository  $forumAnswerRepository
    )
    {
        $this->forumQuestionRepository = $forumQuestionRepository;
        $this->forumAnswerRepository = $forumAnswerRepository;
    }

    public function createForumQuestion(array $data)
    {

        return $this->forumQuestionRepository->create($data);
    }

    public function updateForumQuestion(int $questionId, array $data): bool
    {
        return $this->forumQuestionRepository->update($questionId, $data);
    }

    public function deleteForumQuestion(int $questionId): bool
    {
        return $this->forumQuestionRepository->delete($questionId);
    }

    public function createForumAnswer(int $questionId, array $data)
    {
        return $this->forumAnswerRepository->create($data);
    }

    public function updateForumAnswer(int $answerId, array $data): bool
    {
        return $this->forumAnswerRepository->update($answerId, $data);
    }

    public function deleteForumAnswer(int $answerId): bool
    {
        return $this->forumAnswerRepository->delete($answerId);
    }
}
