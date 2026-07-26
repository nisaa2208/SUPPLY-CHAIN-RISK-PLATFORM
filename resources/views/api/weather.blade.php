@extends('adminlte::page')

@section('title','Global News')

@section('content_header')
<h1>
    <i class="fas fa-newspaper text-primary"></i>
    Global News
</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header bg-primary">

        <h3 class="card-title">

            Latest Global News

        </h3>

    </div>

    <div class="card-body">

        @forelse($articles as $article)

            <div class="mb-4">

                <h4>{{ $article['title'] }}</h4>

                <p>

                    {{ $article['summary'] }}

                </p>

                <small class="text-muted">

                    Published :
                    {{ \Carbon\Carbon::parse($article['published_at'])->format('d M Y H:i') }}

                </small>

                <br>

                <a
                    href="{{ $article['url'] }}"
                    target="_blank"
                    class="btn btn-primary btn-sm mt-2">

                    Read More

                </a>

            </div>

            <hr>

        @empty

            <div class="alert alert-warning">

                No news available.

            </div>

        @endforelse

    </div>

</div>

@stop