<?php

namespace App;

use PDO;

class Database
{
  private $link;

  public function __construct()
  {
    $this->connect();
  }

  private function connect()
  {
    $HOST_NAME = 'localhost';
    $DB_NAME = 'Guest-book_db';
    $USER_NAME = 'root';
    $PASSWORD = 'root';
    $this->link = new PDO("mysql:host={$HOST_NAME};dbname={$DB_NAME}", $USER_NAME, $PASSWORD);

    return $this;
  }

  public function execute($sql)
  {
    $sth = $this->link->prepare($sql);

    return $sth->execute();
  }

  public function query($sql)
  {
    $sth = $this->link->prepare($sql);

    $sth->execute();

    $result = $sth->fetchAll(PDO::FETCH_ASSOC);

    if ($result === false) {
      return [];
    }

    return $result;
  }
}
