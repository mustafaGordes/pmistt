<?php

namespace App\Repositories\Forum;

use App\Models\ForumQuestion;

interface ForumQuestionRepositoryInterface
{
    public function create(array $data): ForumQuestion;

    public function findById(int $id): ?ForumQuestion;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
