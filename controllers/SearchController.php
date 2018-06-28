<?php

namespace Themes\DefaultTheme\Controllers;

use App\Http\Controllers\Frontend\MainController;
use App\Models\Post;
use Accio\Support\Facades\Search;
use App\Models\Theme;
use DateTime;
use Illuminate\Support\Facades\App;

class SearchController extends MainController{

    public function index(){
        $keyword = Search::getKeyword();
        if($keyword) {
            $postsObj = new \App\Models\Post();
            $posts = $postsObj->setTable('post_articles')
                ->published()
                ->where('title','LIKE',"%".$keyword."%")
                ->orderBy('published_at', 'DESC')
                ->paginate(4);

            return view(Theme::view('search/search_results'),compact('keyword','posts'));
        }else{
            return view(Theme::view('search/search_results',compact('keyword')));
        }
    }
}
