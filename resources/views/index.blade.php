@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if($feed)
                    <div class="page-header ">
                        <h1>{{ $feed->title }}
                            <small>Last update: {{ $feed->updated_at->diffForHumans() }}</small>
                        </h1>

                        @if(count($feed_items))
                        <form action="/delete/{{$feed->id}}" method="POST" class="form-horizontal">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-danger" value="Delete News Items">
                        </form>
                        @endif

                    </div>

                    @forelse ($feed_items as $item)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="level">
                                <span class="flex">
                                    <a href="{{ $item->link }}">{{ $item->title }}</a>
                                </span>

                                    <span>posted: {{$item->pubDate}}</span>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="body">{{ $item->description }}</div>
                            </div>
                        </div>
                    @empty
                        <p>There are no relevant results at this time.</p>
                    @endforelse

                    {{ $feed_items->links() }}

                @else
                    <h1>Task for parse haven't been run yet.</h1>
                    <p>Add <code>* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1</code>
                        to your crontab file
                    </p>
                    <p>Wait 5 min or excecute in console <code>php artisan schedule:run</code></p>
                @endif

            </div>
        </div>

    </div>

@endsection
