@extends('layout')

@section('main')
  <section class="listing">
    @foreach($apis as $api)
      <a class="card-container" href="{{ $api->link }}">
        <div class="card">
          <header class="card-header">
            <h2>{{ $api->title }}</h2>
          </header>
          <div class="card-contents">
            {!! $api->description !!}
          </div>
          <footer class="card-footer">
            <small>{{ $api->path }}</small>
          </footer>
        </div>
      </a>
    @endforeach
  </section>
@endsection
