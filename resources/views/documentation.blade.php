@extends('layout')

@section('description')
  <h1>
    {{ $title }}
  </h1>
 {!! $content !!}
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
    @if($parameters)
      @foreach($parameters as $param)
        <tr class="{{ ($param['required']) ? 'required' : 'optional' }}">
          <td>
            {{ $param['id'] }}
          </td>
          <td>
            {{ $param['description'] }}
          </td>
          <td>
            <var>{{ $param['type'] }}</var>
          </td>
        </tr>
      @endforeach
    @endif
    @if($examples)
      <div class="examples">
        @foreach($examples as $example)
          <h4>{{ $example['type'] }}</h4>
          <pre class="{{ $example['type'] }}"><code class="language-{{ $example['type'] }}">{{ $example['example'] }}</code></pre>
        @endforeach
      </div>

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
