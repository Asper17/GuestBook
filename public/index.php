<?php

declare(strict_types=1);

use App\Application;
use App\Template;
use App\Database;

require __DIR__ . '/Dev.php';
require __DIR__ . '/../vendor/autoload.php';

$tem = new Template(__DIR__ . "/../templates/");
$app = new Application;
$db = new Database();

$app->get('/', function () use ($tem, $db) {
  $posts = $db->query("SELECT * FROM `posts` ORDER BY `create_time` DESC");
  $params = [
    'posts' => $posts,
  ];
  return $tem->render('index.phtml', $params);
});

$app->get('/newpost', function () use ($tem) {

  return $tem->render('newpost.phtml');
});

$app->post('/newpost', function () use ($tem, $db) {
  $post = $_REQUEST['post'];
  $username = $post['username'];
  $message = $post['message'];
  $date = time();
  $db->execute("INSERT INTO `posts` (`name`, `message`, `create_time`) VALUES ('{$username}', '{$message}', NOW())");

  return $tem->redirect('/');
});

$app->run();
