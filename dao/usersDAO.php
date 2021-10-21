<?php

require_once( __DIR__ . '/DAO.php');

class usersDAO extends DAO {

  public function selectById($id){
    $sql = "SELECT * FROM `users` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectByUsername($username){
    $sql = "SELECT * FROM `users` WHERE `username` = :username";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insert($data) {
      $sql = "INSERT INTO `users` (`username`, `password`, `id_badges`) VALUES (:username, :password, 0)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':username', $data['username']);
      $stmt->bindValue(':password', $data['password']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
  }

  public function badgeUser($data){
      $sql = "UPDATE `users` SET `id_badges`=:id_badges WHERE `id`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $data['id']);
      $stmt->bindValue(':id_badges', $data['id_badges']);
      if ($stmt->execute()) {
        return $this->selectById($data['id']);
      }
  }
  
  public function acounts(){
    $sql = "SELECT `username`, `password` FROM `users`";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}