<?php

namespace Themes\DefaultTheme\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Theme;
use App\Http\Controllers\Frontend\MainController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\Input;

class PostController extends MainController{

    /**
     * Route names that can be chosen as template from MenuLink
     */
    protected static function menuLinkRoutes(){
        return [
            // Post Type Routes
            'post_type' => [
                'post_articles' => [
                    'defaultRoute' => 'post.articles.index',
                    'list' => [
                        'post.articles.index' => 'Post Articles Index',
                    ]
                ]
            ],

            // Single post
            'post_articles' => [
                'defaultRoute' => 'post.articles.single',
                'list' => [
                    'post.articles.single' => 'Single Post Article'
                ]
            ]
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(){
        if(PostType::validatePostType()){
            return error404();
        }
        $postType = (\Request::route('postTypeSlug') ? \Request::route('postTypeSlug') : "post_articles");
        $posts = (new Post())->setTable($postType)
            ->with(["categories", "featuredimage"])
            ->orderBy('published_at','DESC')
            ->paginate(10);

        return view(Theme::view('posts/index'),compact('posts'));
    }

    public function single(){
        $post = Post::findBySlug(\Request::route('postSlug'), "post_articles");
        if(!$post){
            return error404();
        }

        return view(Theme::view('posts/single'),compact('post', 'users'));
    }
}
