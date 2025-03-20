<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

use App\Models\PostsRelation;

class ViewServiceProvider extends ServiceProvider
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
        // Active Nav Submission
        Blade::directive('active', function ($route) {
            return "<?php echo \Illuminate\Support\Str::startsWith(Route::currentRouteName(), $route) ? 'active' : ''; ?>";
        });

        // Subcat
        View::composer([
            'frontend.components.footer', 
            'frontend.components.header'
        ], function ($view) {
            $subCat = PostsRelation::with('posts_subcategory')
                ->orderBy('id', 'desc')
                ->get()
                ->pluck('posts_subcategory.sub_category')
                ->unique()
                ->toArray();
    
            $view->with('mostSubCat', $subCat);
        });
    }
}
