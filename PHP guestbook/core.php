<?php
class GuestBook {
  private $pdo;//connection with db
  private $stmt;//statement to be executed
  public $error;//displayed error
  function __construct() {//connect with db
    try {
      $this->pdo = new PDO("mysql:unix_socket=/cloudsql/somethingwordpressthingy:us-central1:appdb;dbname=guestbook;","root","test123");
    } catch (Exception $ex) {
      die($ex->getMessage());
    }
  }
  function __destruct() {//destructor closes db connection
    $this->pdo = null;
    $this->stmt = null;
  }
  function get ($pid) {//getting entries
    $this->stmt = $this->pdo->prepare(
      "SELECT * FROM `guestbook` WHERE `post_id`=? ORDER BY `datetime` DESC"
    );
    $this->stmt->execute([$pid]);
    return $this->stmt->fetchall(PDO::FETCH_NAMED);
  }
  //savee entry to db
  function save($pid, $email, $name, $comment, $date=null) {
    if ($date==null) { $date = date("Y-m-d H:i:s"); }
    try {
      $this->stmt = $this->pdo->prepare(
        "REPLACE INTO `guestbook` (`post_id`, `email`, `name`, `comment`, `datetime`) VALUES (?,?,?,?,?)"
      );
      $this->stmt->execute([$pid, $email, $name, $comment, $date]);
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
    return true;
  }
}
//new obj
$_GB = new GuestBook();