<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>{{ $title }} | API</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/prism.css">
    <script src="/scripts/prism.js"></script>
  </head>
  <body>
    <header>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <ul class="nav navbar-nav">
            <li><a href="/">Home</a></li>
          </ul>
        </div>
      </nav>
    </header>
    <main>
      <div class="container">
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
    <footer>

    </footer>
  </body>
</html>
