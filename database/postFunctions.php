<?PHP
// Include connection
require_once "connect.php";

// Include any classes that are needed
require_once "../classes/post.php";

ini_set("display_errors",1);
error_reporting(E_ALL);

function getPost($post_id) : Post {
  $sql = "SELECT * FROM posts WHERE inactive=0 AND post_id=:id";
  $params = [":id" => $post_id];

  $post = getDataFromSQL($sql, $params)[0];
  
  if ($post) {
    return new Post($post["post_id"], $post["creationDate"], $post["author_id"], $post["title"], $post["content"], $post["reports"], $post["inactive"]);
  }
  else return null;
}

function getPosts() : array {
  $sql = "SELECT * FROM posts WHERE inactive=0";

  $posts = getDataFromSQL($sql);

  $post_array = array();

  foreach ($posts as $post) {
    array_push($post_array, new Post($post["post_id"], $post["creationDate"], $post["author_id"], $post["title"], $post["content"], $post["reports"], $post["inactive"]));
  }

  return $post_array;
}

?>