<?php

namespace App;

class Application
{
  private $routers = [];
  private const ERROR_404 = '<h1>404 Not Found</h1>
  <p>The resource could not be found.</p>
  <a href="/">main</a>';

  public function get(string $path, callable $handler)
  {
    $this->addRouter("GET", $path, $handler);
  }

  public function post(string $path, callable $handler)
  {
    $this->addRouter("POST", $path, $handler);
  }

  private function addRouter($method, $path, $handler)
  {
    $this->routers[$method][$path] = $handler;
  }

  private function match($currentUri, $currentMethod)
  {
    if (isset($currentUri) && isset($currentMethod)) {
      return array_key_exists($currentUri, $currentMethod);
    }
    return false;
  }

  public function run()
  {
    $method = $_SERVER["REQUEST_METHOD"];
    $uri = $_SERVER["REQUEST_URI"];

    $currentRouter = $this->routers[$method] ?? [];

    if ($this->match($uri, $currentRouter)) {
      $handler = $currentRouter[$uri];
      echo $handler();
      return;
    }
    echo self::ERROR_404;
    return;
  }
}
