@extends('layout')

@section('main')
  <section class="listing clearfix">
    <div class="container">
      @foreach($apis as $api)
        <a class="card-container col-md-6" href="{{ $api->url }}">
          <div class="card">
            <ul class="requests">
              @foreach($api->requests as $request)
                <li class="{{ $request->type }}"></li>
              @endforeach
            </ul>
            <header class="card-header">
              <h2>{{ $api->title }}</h2>
            </header>
            <div class="card-contents">
              {!! $api->description !!}
            </div>
            <footer class="card-footer">
              <small>{{ $api->url }}</small>
            </footer>
          </div>
        </a>
      @endforeach
    </div>
  </section>
@endsection
