@extends('layout')

@section('description')
  <header class="banner">
    <div class="container">
      <div class="col-lg-10 col-lg-offset-1">
        <h1>
          {{ $title }}
        </h1>
        @unless($listing)
          <ul class="breadcrumbs">
            @if($isapi)
              <li>{{ $route }}</li>
            @endif
            <li>{{ $title }}</li>
          </ul>
          <ul class="methods">
            @foreach($requests as $request)
              <a href="#{{ $request->type }}"><li class="{{ $request->type }}">{{ $request->type }}</li></a>
            @endforeach
          </ul>
        @endunless
      </div>
    </div>
  </header>
  <section class="border-bottom light">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
          {!! $content !!}
        </div>
      </div>
    </div>
  </section>
@endsection

@section('docs')
  @foreach($requests as $request_index=>$request)
    <section class="border-bottom clearfix request" id="{{ $request->type }}">
      <h2 class="text-center {{ $request->type }}">{{ $request->type }}</h2>
      <div class="col-lg-6">
        <div class="col-lg-11 col-lg-offset-1">
          <h2 class="{{ $request->type }}">
            {{ $request->endpoint }}
          </h2>
          @if($request->examples)
            <div class="examples">
              <ul class="tabheading">
                @foreach($request->examples as $index=>$example)
                  <li example-index="{{ $index }}_{{ $request_index }}" {{ ($index==0) ? 'class=selected' : null }}>{{ $example['type'] }}</li>
                @endforeach
              </ul>
              @foreach($request->examples as $index=>$example)
                <div class="example" index="{{ $index }}_{{ $request_index }}">
                  <pre class="{{ $example['type'] }}"><code class="language-{{ $example['type'] }}">{{ $example['example'] }}</code></pre>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
      <div class="col-lg-6">
        <div class="col-lg-11">
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
            @if($request->params)
              @foreach($request->params as $param)
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
          </table>
        </div>
      </div>
    </section>
  @endforeach
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
