<?php

namespace App\Repositories\Forum;

use App\Models\ForumAnswer;

interface ForumAnswerRepositoryInterface
{
    public function create(array $data): ForumAnswer;

    public function findById(int $id): ?ForumAnswer;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
