<?php

namespace Themes\DefaultTheme\Controllers;


use App\Models\Category;
use App\Models\Post;
use App\Models\Theme;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\MainController;
use Accio\Support\Facades\Pagination;

class CategoryController extends MainController{
    /**
     * Define Route names that can be chosen as template from MenuLink
     */
    protected static function menuLinkRoutes(){
        return [
          'defaultRoute' => 'category.posts',
          'list' => [
            'category.posts' => 'Category Posts',
            'category.single' => 'Single Category',
          ]
        ];
    }

    public function single(){
        $category = Category::findBySlug(\Request::route('categorySlug'));
        return view(Theme::view('category.single'), compact('category', 'posts'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Exception
     */
    public function posts(Request $request){
        $category = Category::findBySlug(\Request::route('categorySlug'));
        if(!$category){
            return error404();
        }

        $posts = Post::cache("category_posts_".$category->categoryID, function($query) use($category){
            return $query->generateCacheByCategory($category->categoryID);
        })
          ->published()
          ->orderBy('published_at','DESC')
          ->getItems()
          ->paginate();

        return view(Theme::view('category/posts'),compact('category', 'posts'));
    }

}
