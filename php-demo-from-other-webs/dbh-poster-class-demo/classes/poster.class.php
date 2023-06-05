<?php
// for more informations check 'dbh.class.php';
class Poster extends Dbh
{
  // get all posters
  public function getPosters()
  {
    $sql = "SELECT * FROM posters";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    while($result = $stmt->fetchAll()){
      return $result;
    }
  }

  // create new Poster
  public function addPoster($title, $content, $author)
  {
    $sql = "INSERT INTO posters(title, content, author) VALUES (?, ?, ?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$title, $content, $author]);
  }

  // fetch poster by id
  public function editPoster($id)
  {
    $sql = "SELECT * FROM posters WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);
    $result = $stmt->fetch();

    return $result;
  }

  // update poster by id
  public function updatePoster($title, $content, $author, $id)
  {
    $sql = "UPDATE posters SET title = ?, content = ?, author = ? WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$title, $content, $author, $id]);
  }

  public function delPoster($id)
  {
    $sql = "DELETE FROM posters WHERE id = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);

  }
}
