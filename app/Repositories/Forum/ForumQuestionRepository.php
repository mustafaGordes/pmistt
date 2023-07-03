<?php

namespace App\Repositories\Forum;

use App\Models\ForumQuestion;

class ForumQuestionRepository implements ForumQuestionRepositoryInterface
{
    public function create(array $data): ForumQuestion
    {
        // Yeni bir forum sorusu oluşturma işlemleri
        return ForumQuestion::create($data);
    }

    public function findById(int $id): ?ForumQuestion
    {
        // ID'ye göre forum sorusu bulma işlemleri
        return ForumQuestion::find($id);
    }

    public function update(int $id, array $data): bool
    {
        // Forum sorusunu güncelleme işlemleri
        $forumQuestion = ForumQuestion::find($id);
        if ($forumQuestion) {
            return $forumQuestion->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        // Forum sorusunu silme işlemleri
        $forumQuestion = ForumQuestion::find($id);
        if ($forumQuestion) {
            return $forumQuestion->delete();
        }
        return false;
    }
}
