<?php

namespace App\Providers;

use App\Http\Models\
{Article, ArticleComment, Category, Contact, Link, Tag, WebConfig};
use App\Observers\
{CategoryObserve, CommentObserve, ContactObserve, LinkObserve, WebConfigObserve};
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
        WebConfig::observe(WebConfigObserve::class);
        Link::observe(LinkObserve::class);

        //获取导航
        $h_category = Category::with(['children'=>function ($q) { $q->rememberForever(); }])
            ->where('pid',0)
            ->rememberForever()
            ->get();

        $social_data = WebConfig::type(1)->rememberForever()->get();

        $minute = (strtotime(date('Y-m-d').' 23:59:59')-time())/60;

        //获取最热文章
        $h_hot_article = Article::latest('click')
            ->latest('created_at')
            ->selectRaw('id,title,created_at,click,
                (select count(*) from article_comment where article_comment.article_id=article.id) as comment_count')
            ->remember($minute)
            ->show(1)
            ->take(10)
            ->get();

        //获取评论
        $h_comment = ArticleComment::join('user','article_comment.user_id','=','user.id')
            ->select('article_comment.id','article_comment.article_id',
                'article_comment.content','article_comment.created_at','user.name','user.avatar')
            ->remember($minute)
            ->take(10)
            ->latest()
            ->get();

        //首页footer内容
        $footerData =  WebConfig::type(2)
            ->remember($minute)
            ->cacheTags(config('blog.blog_footer_cache_key'))
            ->get()
            ->groupBy('name');

        //标签云
        $tagCloud = Tag::rememberForever()->get();

        //友情链接
        $friendLink = Link::show(1)
            ->rememberForever()
            ->latest('order')
            ->oldest('created_at')
            ->get();

        //统计总文章和浏览数
        $totalArticle = Article::count();

        view()->share('totalArticle', $totalArticle);
        view()->share('dh', $h_category);
        view()->share('hotArticle', $h_hot_article);
        view()->share('comment_t', $h_comment);
        view()->share('tagCloud', $tagCloud);
        view()->share('friendLink', $friendLink);
        view()->share('socialData', $social_data);
        view()->share('footerData', $footerData);
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
