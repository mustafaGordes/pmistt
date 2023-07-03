<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forum\CreateForumAnswerRequest;
use App\Http\Requests\Forum\CreateForumQuestionRequest;
use App\Http\Requests\Forum\UpdateForumAnswerRequest;
use App\Http\Requests\Forum\UpdateForumQuestionRequest;
use App\Models\ForumQuestion;
use App\Services\Forum\ForumQuestionService;
use App\Services\Forum\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function show()
    {
        $forumQuestions = ForumQuestion::all();
        return view('forms.index', compact('forumQuestions'));
    }

    private $forumQuestionService;
    private $imageService;
    private $userId;

    public function __construct(
        ForumQuestionService $forumQuestionService,
        ImageService $imageService
    )
    {
        $this->forumQuestionService = $forumQuestionService;
        $this->imageService = $imageService;
        $this->userId = Auth::id();
    }


    public function create(CreateForumQuestionRequest $request): JsonResponse
    {

        $data = $request->validated();
        $data['image'] = $this->imageService->processImage($request);
        // Oturum açmış kullanıcının kimliğine erişme
        $data['user_id'] = $this->userId;
        $forumQuestion = $this->forumQuestionService->createForumQuestion($data);


        if ($forumQuestion) {
            return response()->json(['message' => 'Forum question created successfully', 'data' => $forumQuestion], 201);
        } else {
            return response()->json(['message' => 'Failed to create forum question'], 500);
        }
    }

    public function update(UpdateForumQuestionRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = $this->imageService->processUpdateImage($request);
        $data['user_id'] = $this->userId;
        $success = $this->forumQuestionService->updateForumQuestion($id, $data);

        if ($success) {
            return response()->json(['message' => 'Forum question updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update forum question'], 500);
        }
    }

    public function delete(int $id): JsonResponse
    {
        $data['user_id'] = $this->userId;
        $success = $this->forumQuestionService->deleteForumQuestion($id);

        if ($success) {
            return response()->json(['message' => 'Forum question deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete forum question'], 500);
        }
    }

    public function answer(CreateForumAnswerRequest $request, int $questionId): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $this->userId;
        $answer = $this->forumQuestionService->createForumAnswer($questionId, $data);

        if ($answer) {
            return response()->json(['message' => 'Forum answer created successfully', 'data' => $answer], 201);
        } else {
            return response()->json(['message' => 'Failed to create forum answer'], 500);
        }
    }

    public function updateAnswer(UpdateForumAnswerRequest $request, int $answerId): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $this->userId;
        $success = $this->forumQuestionService->updateForumAnswer($answerId, $data);

        if ($success) {
            return response()->json(['message' => 'Forum answer updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update forum answer'], 500);
        }
    }

    public function deleteAnswer(int $answerId): JsonResponse
    {
        $data['user_id'] = $this->userId;
        $success = $this->forumQuestionService->deleteForumAnswer($answerId);

        if ($success) {
            return response()->json(['message' => 'Forum answer deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete forum answer'], 500);
        }
    }
}

