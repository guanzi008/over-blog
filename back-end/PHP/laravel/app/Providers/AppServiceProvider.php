<?php

namespace App\Providers;

use App\Http\Models\ArticleComment;
use App\Http\Models\Category;
use App\Http\Models\Contact;
use App\Observers\CategoryObserve;
use App\Observers\CommentObserve;
use App\Observers\ContactObserve;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Contact::observe(ContactObserve::class);
        ArticleComment::observe(CommentObserve::class);
        Category::observe(CategoryObserve::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
