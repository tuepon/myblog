<?php
require 'classes/Database.php';

$database = new Database;

// Sanitize
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(isset($_POST['submit'])){
  $title = $_POST['title'];
  $body = $post['body'];

  $database->query('INSERT INTO posts (title, body) VALUES(:title, :body)');
  $database->bind(':title', $title);
  $database->bind(':body', $body);
  $database->execute();
  if($database->lastInsertId()){
    echo '<p>Post Added!</p>';
  }
}

// Make a query
$database->query('SELECT * FROM posts');
$rows = $database->resultSet();
?>
<h1>Add Posts</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
  <label>Post Title</label><br>
  <input type="text" name="title" placeholder="Add a Title..." /><br><br>
  <label>Post Body</label><br>
  <textarea name="body"></textarea><br><br>
  <input type="submit" name="submit" value="Submit" />
</form>

<div>
<?php foreach($rows as $row) : ?>
  <div>
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['body']; ?></p>
  </div>
<?php endforeach; ?>
</div>