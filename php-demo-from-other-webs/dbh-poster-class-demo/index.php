<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('./includes/classAutoloader.inc.php');
require_once('./models/header.php');

?>

<!-- Button trigger modal -->
<div class="text-center">
  <button type="button" class="btn btn-primary my-5" data-bs-toggle="modal" data-bs-target="#addPostModal">
    Create new Post
  </button>
</div>

<!-- Modal -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- from inputs -->
        <form action="post.process.php" method="POST" class="row row-cols-1 g-4">
          <div class="col">
            <label>Title: </label>
            <input class="form-control" name="post-title" type="text" required>
          </div>
          <div class="col">
            <label>Content: </label>
            <textarea class="form-control" name="post-content" type="text" rows="2" required></textarea>
          </div>
          <div class="col">
            <label>Author: </label>
            <input class="form-control" name="post-author" type="text" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="submit" class="btn btn-primary">Add Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Posters -->
  <?php $posters = new Poster(); ?>
  <?php
  if ($posters->getPosters()) {
    foreach ($posters->getPosters() as $poster) {  ?>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="car-title"><?= $poster['title']; ?></h5>
            <p class="card-text"><?= $poster['content']; ?></p>
            <h6 class="card-subtitle text-muted text-end">
              Author: <?= $poster['author']; ?>
            </h6>
            <a href="editPost.php?id=<?= $poster['id']; ?>" class="btn btn-warning">Edit</a>
            <a href="post.process.php?id=<?= $poster['id']; ?>&act=del" class="btn btn-danger">Delete</a>
          </div>
        </div>
      </div>
    <?php }
  } else { ?>
    <p>Poster is Empty</p>
  <?php  }; ?>
</div>

<?php
require_once('./models/footer.php');
?>