<?php

namespace App\Http\Middleware;

use App\Lib\Page;
use Closure;

class Exists
{
    public function handle($request, Closure $next)
    {
      $endpoint = new Page($request->path());
      return $endpoint->exists() ? $next($request) : abort(404);
    }
}
