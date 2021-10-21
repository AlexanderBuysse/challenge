<?php

require_once( __DIR__ . '/DAO.php');

class video_reactionsDAO extends DAO {
    public function selectById($id){
    $sql = "SELECT * FROM `video_reactions` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


    public function insert($data) {
      $sql = "INSERT INTO `video_reactions` (`id_video`, `id_account`) VALUES (:id_video, :id_account)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id_video', $data['id_video']);
      $stmt->bindValue(':id_account', $data['id_account']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
  }

  public function numberLikes(){
    $sql = "SELECT id_video, COUNT(*) FROM video_reactions GROUP BY id_video";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function numberLikesAccount($id_account){
    $sql = "SELECT id_video, COUNT(*) FROM video_reactions WHERE `id_account`=:id_account GROUP BY id_video";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id_account', $id_account);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function numberLikeOneId($id_video){
    $sql = "SELECT id_video, COUNT(*) FROM video_reactions WHERE `id_video`= :id_video GROUP BY `id_video`";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id_video', $id_video);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function numberLikesPopular(){
    $sql = "SELECT id_video, COUNT(*) FROM video_reactions GROUP BY id_video ORDER BY `COUNT(*)`  DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}