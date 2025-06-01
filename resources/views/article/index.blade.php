@extends("layouts.app")

@section("content")

    

    <div class="container" style="max-width: 800px">
        @if (session("info"))
    <div class="alert alert-info">
        {{session("info")}}
    </div>
        
    @endif
        {{ $articles->links()}}
        @foreach ($articles as $article)
            <div class="card mb-2">
                <div class="card-body">
                    <h4>{{$article->title}}</h4>
                    <div class="text-muted">
                        <b class="text-success">{{ $article->user->name }} </b>
                        <b>Category:: </b>{{ $article->category->name}},
                        <b>Comments:: </b>{{count($article->comments)}}
                        {{ $article->created_at}}
                    </div>
                    <p>
                        {{ $article->body }}
                    </p>
                    <a href="{{url("/articles/detail/$article->id") }}">View Detail</a>
                </div>
            </div>
        @endforeach
    </div>
    @endsection