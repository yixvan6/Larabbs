@extends('layouts.app')
@section('title', $topic->title)
@section('description', $topic->excerpt)

@section('content')

<div class="row">
  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
    <div class="card">
      <div class="card-body">
        <div class="text-center">
          作者：{{ $topic->user->name }}
        </div>
        <hr>
        <div class="media">
          <div align="center">
            <a href="{{ route('users.show', $topic->user_id) }}">
              <img src="{{ $topic->user->avatar }}" class="thumbnail img-fluid" width="300px" height="300px">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
    <div class="card">
      <div class="card-body">
        <h1 class="text-center mt-3 mb-3">{{ $topic->title }}</h1>

        <div class="article-meta text-center text-secondary">
          {{ $topic->created_at->diffForHumans() }}
          ·
          <i class="far fa-comment"></i>
          {{ $topic->reply_count }}
        </div>

        <div class="topic-body mt-4 mb-4">
          {!! $topic->body !!}
        </div>

        <div class="operate">
          <hr>
          @can('update', $topic)
            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
              <i class="far fa-edit"></i> 编辑
            </a>

            <form action="{{ route('topics.destroy', $topic->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('确定要删除吗？');">
              @method('DELETE')
              @csrf
              <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="far fa-trash-alt"></i> 删除
              </button>
            </form>
          @endcan
        </div>

      </div>
    </div>

    {{-- 话题回复列表 --}}
    <div class="card topic-reply mt-4">
      <div class="card-body">
        @includeWhen(Auth::check(), 'topics._reply_box', $topic)
        @include('topics._reply_list', ['replies' => $topic->replies()->with('user')->get()])
      </div>
    </div>

  </div>
</div>

@stop
