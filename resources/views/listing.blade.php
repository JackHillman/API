@extends('layout')

@section('description')
 {{ $content }}
@endsection

@section('listing')
  <ul>
    @foreach($api_list as $api)
      <li><a href="{{ $api->link }}">{{ $api->title }}</a></li>
    @endforeach
  </ul>
@endsection
