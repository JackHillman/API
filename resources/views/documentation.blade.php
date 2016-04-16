@extends('layout')

@section('description')
  <h1>
    {{ $title }}
  </h1>
 {{!! $content !!}}
@endsection

@section('docs')
  <h2 class="{{ $request }}">
    <span class="label label-primary">{{ $request }}</span>
    {{ $endpoint }}
  </h2>
  <table class="table table-striped table-bordered">
    <tr>
      <th>
        <strong>Paremeter</strong>
      </th>
      <th>
        <strong>Description</strong>
      </th>
      <th>
        <strong>Type</strong>
      </th>
    </tr>
    @foreach($parameters as $param)
      <tr class="{{ ($param['optional']) ? 'optional' : 'required' }}">
        <td>
          {{ $param['title'] }}
        </td>
        <td>
          {{ $param['desc'] }}
        </td>
        <td>
          <var>{{ $param['type'] }}</var>
        </td>
      </tr>
    @endforeach
    @if($example['return'])
      <pre>
        {{ $example['return'] }}
      </pre>
    @endif
  </table>
@endsection

@section('listing')
  <ul>
    @foreach($api_list as $api)
      <li>
        <a href="{{ $api['link'] }}">{{ $api['title'] }}</a>
      </li>
    @endforeach
  </ul>
@endsection
