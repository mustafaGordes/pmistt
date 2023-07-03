<?php

namespace App\Repositories\Forum;

use App\Models\ForumAnswer;

class ForumAnswerRepository implements ForumAnswerRepositoryInterface
{
    public function create(array $data): ForumAnswer
    {
        return ForumAnswer::create($data);
    }

    public function findById(int $id): ?ForumAnswer
    {
        return ForumAnswer::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $forumAnswer = $this->findById($id);

        if ($forumAnswer) {
            return $forumAnswer->update($data);
        }

        return false;
    }

    public function delete(int $id): bool
    {
        $forumAnswer = $this->findById($id);

        if ($forumAnswer) {
            return $forumAnswer->delete();
        }

        return false;
    }
}
