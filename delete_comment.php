<?php

require_once('Class_Library/class_comment.php');

$comment = new Comment();

extract($_POST);
$response = $comment->delete_Comment($commentId,$postId,$flag);

return $response;
?>
