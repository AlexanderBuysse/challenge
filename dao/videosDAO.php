<?php

require_once( __DIR__ . '/DAO.php');

class videosDAO extends DAO {
  public function selectById($id){
    $sql = "SELECT * FROM `videos` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insert($data) {
      $sql = "INSERT INTO `videos` (`time`, `id_account`, `path`, `path_thumbnail`) VALUES (:time, :id_account, :path, :path_thumbnail)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id_account', $data['id_account']);
      $stmt->bindValue(':path', $data['path']);
      $stmt->bindValue(':time', $data['time']);
      $stmt->bindValue(':path_thumbnail', $data['path_thumbnail']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
    return false;
  }

  public function selectVideosByAccountRecent($id){
    $sql = "SELECT * FROM `videos` WHERE `id_account` = :id ORDER BY `id` DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectVideosByAccountTime($id){
    $sql = "SELECT * FROM `videos` WHERE `id_account` = :id ORDER BY `time`";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectAllVideosRecent(){
    $sql = "SELECT * FROM `videos` ORDER BY `id`  DESC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectAllVideosTime(){
    $sql = "SELECT * FROM `videos` ORDER BY `time`  ASC";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function amountVideos(){
    $sql = "SELECT COUNT(path) FROM videos WHERE path_thumbnail=0";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function amountVideosAccount($id){
    $sql = "SELECT COUNT(path) FROM videos WHERE id_account=:id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}