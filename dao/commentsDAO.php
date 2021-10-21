<?php

require_once( __DIR__ . '/DAO.php');

class commentsDAO extends DAO {

    public function getComments($id_video){
      $sql = "SELECT * FROM `comments` WHERE `id_video` = :id_video";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id_video', $id_video);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentsAccount($id_account){
      $sql = "SELECT * FROM `comments` WHERE `id_account` = :id_account";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id_account', $id_account);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


  public function selectById($id){
    $sql = "SELECT * FROM `comments` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

    public function insert($data) {
      $sql = "INSERT INTO `comments` (`comment`, `id_video`, `id_account`, `username`) VALUES (:comment, :id_video, :id_account, :username)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':comment', $data['comment']);
      $stmt->bindValue(':id_video', $data['id_video']);
      $stmt->bindValue(':id_account', $data['id_account']);
      $stmt->bindValue(':username', $data['username']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
  }

  public function commentsAccountCount($id){
    $sql = "SELECT COUNT(*) FROM comments WHERE `id_account`=:id GROUP BY id_account";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


}