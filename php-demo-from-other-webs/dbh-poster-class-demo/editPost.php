<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./models/header.php');
include('./includes/classAutoloader.inc.php');

$poster = new Poster();
$poster = $poster->editPoster($_GET['id']);
$id = $poster['id'];
$title = $poster['title'];
$content = $poster['content'];
$author = $poster['author'];

?>

<div class="text-center my-4">
	<h3>Edit Poster</h3>
</div>
<div class="row">
	<div class="col-md-7 mx-auto">
		<!-- from inputs -->
		<form action="post.process.php?id=<?= $id;?>" method="POST" class="row row-cols-1 g-4">
			<div class="col">
				<label>Title: </label>
				<input class="form-control" name="edit-title" type="text" value="<?= $title; ?>" required>
			</div>
			<div class="col">
				<label>Content: </label>
				<textarea class="form-control" name="edit-content" type="text" rows="2" required><?= $content; ?></textarea>
			</div>
			<div class="col">
				<label>Author: </label>
				<input class="form-control" name="edit-author" type="text" value="<?= $author; ?>" required>
			</div>
			<button href="" type="submit" name="update" class="btn btn-primary">Update Poster</button>
			<a href="index.php" type="button" class="btn btn-secondary">Close</a>
		</form>

	</div>
</div>

<?php
require_once('./models/footer.php');
?>