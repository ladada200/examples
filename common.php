<?php
if(isdoc !== 1) // Not identical to 1
{
    header('HTTP/1.1 404 Not Found');
    echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n<html><head>\n<title>404 Not Found</title>\n</head>";
    echo "<body>\n<h1>Not Found</h1>\n<p>The requested URL ".$_SERVER['REQUEST_URI']." was not found on this server.</p>\n";
    echo "<hr>\n".$_SERVER['SERVER_SIGNATURE']."\n</body></html>\n";
    // Echo output similar to Apache's default 404 (if thats what you're using)
    exit;
}
//This section will be used solely for required functions/classes.

class makeFriends {
  protected $friend = '';
  public $bestFriend = '';
  const CONSTANT = 'Chris';

  public function friendConst($friend) {
    echo $friend, PHP_EOL;
    //echo self::CONSTANT, PHP_EOL;
  }

}

class newFriends extends makeFriends {
  protected $superbFriend = "Rebecca";

  public function testIt($friend) {
    echo $this->friendConst($friend);
  }
  public function __construct() {
    $this->bestFriend = $this->superbFriend;
  }
}

$giveMe = new newFriends;


?>
