<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/classAutoloader.inc.php');

$poster = new Poster;
if (isset($_POST['submit'])) {
	$title = $_POST['post-title'];
	$content = $_POST['post-content'];
	$author = $_POST['post-author'];

	$poster->addPoster($title, $content, $author);
	header("Location: {$_SERVER['HTTP_REFERER']}");

} else if (isset($_POST['update'])) {
	$title = $_POST['edit-title'];
	$content = $_POST['edit-content'];
	$author = $_POST['edit-author'];
	$id = $_GET['id'];

	$poster->updatePoster($title, $content, $author, $id);
	header("Location: index.php");

} else if ($_GET['act'] === 'del') {

	$id = $_GET['id'];
	$poster->delPoster($id);
	header("Location: index.php");

}

?>