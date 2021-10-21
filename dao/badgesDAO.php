<?php

require_once( __DIR__ . '/DAO.php');

class badgesDAO extends DAO {
  public function selectById($id){
    $sql = "SELECT * FROM `badges` WHERE `id` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function selectByAccountId($id){
    $sql = "SELECT * FROM `badges` WHERE `id_account` = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function insert($data) {
      $sql = "INSERT INTO `badges` (`id_account`, `1poging`, `10pogingen`, `coach`, `geeflike`, `nummer1`, `populair`, `ranglijst`, `tijd`, `tip`, `uitdager`) VALUES (:id_account, false, false, false, false, false, false, false, false, false, false)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id_account', $data['id']);
      if ($stmt->execute()) {
        return $this->selectById($this->pdo->lastInsertId());
      }
    return false;
  }

  public function updateBadgeGeefLike($id){
      $sql = "UPDATE `badges` SET `geeflike`=1 WHERE `id_account`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      if ($stmt->execute()) {
        return $this->selectById($id);
        }
  }

  public function updateBadgeCoach($id){
      $sql = "UPDATE `badges` SET `coach`=1 WHERE `id_account`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      if ($stmt->execute()) {
        return $this->selectById($id);
        }
  }

  public function updateBadgeTip($id){
      $sql = "UPDATE `badges` SET `tip`=1 WHERE `id_account`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      if ($stmt->execute()) {
        return $this->selectById($id);
        }
  }

  public function updateBadgeTijd($id){
      $sql = "UPDATE `badges` SET `tijd`=1 WHERE `id_account`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      if ($stmt->execute()) {
        return $this->selectById($id);
        }
  }

  public function updateBadgePoging($id){
      $sql = "UPDATE `badges` SET `1poging`=1 WHERE `id_account`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      if ($stmt->execute()) {
        return $this->selectById($id);
      }
  }

  public function updateBadgePogingen($id){
      $sql = "UPDATE `badges` SET `10pogingen`=1 WHERE `id_account`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      if ($stmt->execute()) {
        return $this->selectById($id);
      }
  }

  public function updateBadgePopulair($id){
      $sql = "UPDATE `badges` SET `populair`=1 WHERE `id_account`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      if ($stmt->execute()) {
        return $this->selectById($id);
      }
  }

  public function updateBadgeRanglijst($id){
      $sql = "UPDATE `badges` SET `ranglijst`=1 WHERE `id_account`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      if ($stmt->execute()) {
        return $this->selectById($id);
      }
  }

  public function updateBadgeNummerEen($id){
      $sql = "UPDATE `badges` SET `nummer1`=1 WHERE `id_account`=:id";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      if ($stmt->execute()) {
        return $this->selectById($id);
      }
  }
}