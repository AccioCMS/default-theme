@extends('DefaultTheme.views.index')

@section('meta')
    {{--{{metaTags($post)}}--}}
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-8 blog-main">

                <div class="blog-post">
                    <h2 class="blog-post-title">{{$post->title}}</h2>
                    <p class="blog-post-meta">
                        @if($post->user)
                            {{$post->created_at->diffForHumans()}} @lang('base.by')
                            <a href="{{ route('user.single',['authorSlug' => $post->user->slug])}}">
                                <img class="avatar" src="{{ $post->user->avatar(200,200,true)}}" alt="" />
                                {{ $post->user->fullName}}
                            </a>
                        @endif
                    </p>

                    <div class="post-wrapper">
                        @if($post->hasFeaturedVideo())
                            {{$post->printFeaturedVideo()}}
                        @elseif($post->hasFeaturedImage())
                            {{$post->printFeaturedImage()}}
                        @endif

                        <div class="post-content">
                            <?php
                            print $post->content();
                            ?>
                        </div>
                    </div>
                </div>
                {!! $post->printTags() !!}

            </div><!-- /.blog-main -->

            <div class="col-sm-3 offset-sm-1 blog-sidebar">
                <div class="sidebar-module sidebar-module-inset">
                    <h4>About</h4>
                    <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                </div>
                <div class="sidebar-module">
                    <h4>Archives</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">March 2014</a></li>
                        <li><a href="#">February 2014</a></li>
                        <li><a href="#">January 2014</a></li>
                        <li><a href="#">December 2013</a></li>
                        <li><a href="#">November 2013</a></li>
                        <li><a href="#">October 2013</a></li>
                        <li><a href="#">September 2013</a></li>
                        <li><a href="#">August 2013</a></li>
                        <li><a href="#">July 2013</a></li>
                        <li><a href="#">June 2013</a></li>
                        <li><a href="#">May 2013</a></li>
                        <li><a href="#">April 2013</a></li>
                    </ol>
                </div>
                <div class="sidebar-module">
                    <h4>Elsewhere</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ol>
                </div>
            </div><!-- /.blog-sidebar -->

        </div><!-- /.row -->

    </div>

@endsection