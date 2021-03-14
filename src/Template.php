<?php

namespace App;

class Template
{
  private $path;

  public function __construct($path)
  {
    $this->path = $path; 
  }

  public function render($fileName, $params = [])
  {
    $templatePath = $this->path . $fileName;
    return $this->getTemplate($templatePath, $params);
  }

  private function getTemplate($template, $variabels)
  {
    ob_start();
    extract($variabels);
    include $template;
    return ob_get_clean();
  }

  public function redirect($uri)
  {
    return header("Location: $uri");
  }
  
}
