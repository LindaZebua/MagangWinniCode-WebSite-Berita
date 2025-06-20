<?php // Pastikan ini ada di baris pertama dan tidak ada spasi/enter di atasnya

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\News; // Impor model News
use App\Models\Category; // Impor model Category
use App\Models\User;     // Impor model User
use App\Models\Comment;  // Impor model Comment
use App\Models\Media;  

class ViewComposerServiceProvider extends ServiceProvider // Pastikan class ini dimulai dengan { dan diakhiri dengan }
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Bagikan data ke semua views yang menggunakan 'frontend.*' atau spesifik
        View::composer(['frontend.app', 'frontend.sidebar'], function ($view) {
            $categories = Category::withCount('news')->orderBy('category_name')->get();
            $popularNews = News::with('category')
                                ->whereNotNull('published_at')
                                ->where('published_at', '<=', now())
                                ->orderByDesc('views')
                                ->take(3)
                                ->get();
            $flickrPhotos = Media::inRandomOrder()->take(6)->get();

            $view->with(compact('categories', 'popularNews', 'flickrPhotos'));
        });
         View::composer('content.layouts.main', function ($view) {
            $newsCount = News::count();
            $categoriesCount = Category::count();
            $usersCount = User::count();
            $commentsCount = Comment::count();
            $mediaCount = Media::count();

            $view->with(compact(
                'newsCount',
                'categoriesCount',
                'usersCount',
                'commentsCount',
                'mediaCount'
            ));
        });
    }
} // Pastikan ada kurung kurawal tutup ini untuk class ViewComposerServiceProvider