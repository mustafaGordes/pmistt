<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Forum\ForumQuestionRepository;
use App\Repositories\Forum\ForumQuestionRepositoryInterface;
use App\Repositories\Forum\ForumAnswerRepository;
use App\Repositories\Forum\ForumAnswerRepositoryInterface;
use App\Services\Forum\ForumQuestionService;
use App\Services\Forum\ForumQuestionServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ForumQuestionRepositoryInterface::class, ForumQuestionRepository::class);
        $this->app->bind(ForumAnswerRepositoryInterface::class, ForumAnswerRepository::class);
        $this->app->bind(ForumQuestionServiceInterface::class, ForumQuestionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
