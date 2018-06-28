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

    public function single($TYPE){
        $category = Category::findBySlug(\Request::route('categorySlug'));
        return view(Theme::view('category.single'), compact('category', 'posts'));
    }

    public function posts(Request $request){
        $category = Category::findBySlug(\Request::route('categorySlug'));
        if(!$category){
            return error404();
        }

        $posts = Post::getFromCache(\Request::route('postTypeSlug'), [
          'where'=> [
            'categoryID' => $category->categoryID,
            'post_type' => \Request::route('postTypeSlug')
          ]]
        );
        $posts = Pagination::LengthAwarePaginator($posts);
        return view(Theme::view('category/posts'),compact('category', 'posts'));
    }

}
