@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header ">
                    <h1>{{ $feed->title }}
                        <small>Last update: {{ $feed->updated_at->diffForHumans() }}</small>
                    </h1>
                    <form action="/delete/{{$feed->id}}" method="POST" class="form-horizontal">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger" value="Delete News Items">
                    </form>


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
            </div>
        </div>

    </div>

@endsection
