<?php

namespace App\Services\Forum;

use App\Models\ForumQuestion;

interface ForumQuestionServiceInterface
{
    public function createForumQuestion(array $data): ForumQuestion;

    public function updateForumQuestion(int $questionId, array $data): bool;

    public function deleteForumQuestion(int $questionId): bool;

    public function createForumAnswer(int $questionId, array $data);

    public function updateForumAnswer(int $answerId, array $data): bool;

    public function deleteForumAnswer(int $answerId): bool;
}
