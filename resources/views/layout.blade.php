<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{ $title }} | API</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/prism.css">
    <script src="/scripts/prism.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script src="/scripts/main.js"></script>

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Source+Code+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
  </head>
  <body>
    <header>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <ul class="nav navbar-nav">
            <li><a href="/"><i class="fa fa-code logo" aria-hidden="true"></i></a></li>
          </ul>

          <ul class="nav navbar-nav pull-right">
            <li><a href="/search" class="search-toggle"><i class="fa fa-search"></i></a></li>
          </ul>
        </div>
      </nav>
    </header>
    <main>
      <div class="container-fluid">
        <div class="row">
          <article class="description">
            @yield('description')
          </article>

          @if($documentation)
            <article class="documentation">
              @if($isapi)
                <section class="api">
                  @yield('docs')
                </section>
              @elseif($listing)
                <section class="listing">
                  @yield('listing')
                </section>
              @endif
            </article>
          @endif

        </div>
      </div>
    </main>
    <footer id="footer">
      <footer>
        Made by <a href="https://jackhillman.com.au/">Jack Hillman</a>
      </footer>
    </footer>
    <div id="search">
      <i class="fa fa-caret-up search-toggle" aria-hidden="true"></i>
      <form>
        <input type="text" name="search">
      </form>
      <div class="results-container container">
        <ul class="results list-unstyled">
          
        </ul>
      </div>
    </div>
  </body>
</html>
