<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/usersDAO.php';
require_once __DIR__ . '/../dao/badgesDAO.php';
require_once __DIR__ . '/../dao/videosDAO.php';
require_once __DIR__ . '/../dao/commentsDAO.php';
require_once __DIR__ . '/../dao/video_reactionsDAO.php';


class PagesController extends Controller {
  private $usersDAO;
  private $badgesDAO;
  private $videosDAO;
  private $commentsDAO;
  private $video_reactionsDAO;


  function __construct() {
    $this->usersDAO = new usersDAO();
    $this->badgesDAO = new badgesDAO();
    $this->videosDAO = new videosDAO();
    $this->commentsDAO = new commentsDAO();
    $this->video_reactionsDAO = new video_reactionsDAO();
  }

  public function index() { 
  }

  public function rules(){

  }

  public function logout(){
    if (!empty($_SESSION['user'])) {
      unset($_SESSION['user']);
    }
    $_SESSION['info'] = 'uitgelogd';
    header('location:index.php');
    exit();
  }

  public function login(){
    if(isset($_SESSION['user'])){
      header('Location: index.php?');
      exit();
    }
    if(!empty($_POST['action'])){
      $errors=array();

      if($_POST['action']==='register'){
        if(!is_string($_POST['username'] ?? null) || trim($_POST['username']) === '' || strlen($_POST['username']) > 80){
          $errors['username']= 'vul een gebruikersnaam van maximaal 80 tekens in';
        } else{
          $exciting=$this->usersDAO->selectByUsername($_POST['username']);
          if(!empty($exciting)){
            $errors['username']= 'deze gebruikersnaam bestaat al';
          }
        }

      if (!is_string($_POST['password'] ?? null) || $_POST['password'] === '' || strlen($_POST['password']) > 72 || strpos($_POST['password'], chr(0)) !== false) {
        $errors['password'] = 'geef een wachtwoord op';
      }
      if (($_POST['confirm_password'] ?? null) !== ($_POST['password'] ?? null)) {
        $errors['confirm_password'] = 'wachtwoord komt niet overeen';
      }

      if (empty($errors)) {
        $inserteduser = $this->usersDAO->insert(array(
          'username' => $_POST['username'],
          'password' => password_hash($_POST['password'], PASSWORD_BCRYPT)
        ));
        if (!empty($inserteduser)) {
          $badgesUser= $this->badgesDAO->insert($inserteduser);

          $this->usersDAO->badgeUser(array(
          'id' => $inserteduser['id'],
          'id_badges' => $badgesUser['id']
          ));

          $_SESSION['info'] = 'Registratie Successful!';
          header('location:index.php');
          exit();
        }
      }
      $_SESSION['error'] = 'Registratie gefaald!';
      $this->set('errors', $errors);
      }

      if($_POST['action']==='login'){
        if (is_string($_POST['username'] ?? null) && is_string($_POST['password'] ?? null)) {
        $existing = $this->usersDAO->selectByUsername($_POST['username']);
        if (!empty($existing)) {
          if (password_verify($_POST['password'], $existing['password'])) {
            session_regenerate_id(true);
            unset($existing['password']);
            $_SESSION['user'] = $existing;
            $_SESSION['info'] = 'ingelogd!';
            header('location:index.php');
            exit();
          } else {
            $_SESSION['error'] = 'ongekende gebruikersnaam / wachtwoord';
          }
        } else {
          $_SESSION['error'] = 'ongekende gebruikersnaam / wachtwoord';
        }
      } else {
        $_SESSION['error'] = 'ongekende gebruikersnaam / wachtwoord';
      }
      }
    }
  }

  public function feed(){
    if (!in_array($_GET['choice'] ?? null, ['all', 'personal', 'video'], true)
        || ($_GET['choice'] === 'personal' && !isset($_SESSION['user']))) {
      header('Location: index.php?');
      exit();
    }

    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && $contentType === "application/json") {

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true);
        header('Content-Type: application/json; charset=utf-8');
        $data = $this->feedInput(is_array($data) ? $data : []);
        if ($data === null) {
          echo json_encode(['error' => 'Kies een bestaande poging en vul je reactie in.']);
          exit();
        }

        if($data['action']==='add-like'){
        $insertedReaction= $this->video_reactionsDAO->insert($data);
        if(!$insertedReaction){
          $errors['error'] = "Er zijn fouten opgetreden";
          echo json_encode($errors);
        }else{
          $numberRating['like']= $this->video_reactionsDAO->numberLikeOneId($data['id_video']);
          if($numberRating['like']===false){
            $numberRating['like']['COUNT(*)']=0;
          }

          if(isset($_SESSION['user'])){
            $badges=$this->badgesDAO->selectByAccountId($_SESSION['user']['id']);
            if(!$badges['geeflike']){
              $this->badgesDAO->updateBadgeGeefLike($_SESSION['user']['id']);
              $numberRating['info']='Badge verdient: "Geef Like';
            }
          }

          echo json_encode($numberRating);
        }

        exit();
      }

      if($data['action']==='add-comment'){
        $insertedcomment = $this->commentsDAO->insert($data);
        if(!$insertedcomment){
          $errors['error'] = "Er zijn fouten opgetreden";
          $this->set('errors',$errors);
          echo json_encode($errors);
        }else{

          $comments['comments'] = $this->commentsDAO->getComments($data['id_video']);
          if(isset($_SESSION['user'])){
            $badges=$this->badgesDAO->selectByAccountId($_SESSION['user']['id']);
            if(!$badges['tip']){
              $this->badgesDAO->updateBadgeTip($_SESSION['user']['id']);
              $comments['info']='Badge verdient: "Geef Tip';
            }
          }
          echo json_encode($comments);
        }
        exit();
      }
    }

    if (!empty($_POST)) {
      $_POST = $this->feedInput($_POST) ?? [];
    }

    $videosTime=$this->videosDAO->selectAllVideosTime();
    $rangPositions=array();
    foreach ($videosTime as $key=>$videoTime){
      $rangPositions[$videoTime['id']]= $key+1;
    }

    $this->set('rangPosition',$rangPositions);

    $rangTen=array();
    foreach ($rangPositions as $key=>$rangPosition){
      $video=$this->videosDAO->selectById($key);
      $rangTen[]=array(
        'time'=> $video['time'],
        'username'=> $this->usersDAO->selectById($video['id_account'])['username']
      );
    }
    $this->set('rangTen', $rangTen);

    $sort = $_GET['sort'] ?? 'id';
    $allowedSorts = $_GET['choice'] === 'all' ? ['id', 'time', 'popular'] : ['id', 'time'];
    if (!in_array($sort, $allowedSorts, true)) {
      $sort = 'id';
    }

    
    $likes= $this->video_reactionsDAO->numberLikes();
    $keyVideoIdLikes = array();
    foreach ($likes as $like){
    $keyVideoIdLikes[$like['id_video']]= $like['COUNT(*)'];
    }
    $this->set('allLikes', $keyVideoIdLikes);

    $amountVideo=$this->videosDAO->amountVideos();
    $this->set('amountVideo', $amountVideo['COUNT(path)']);

    if($_GET['choice']==='personal'){
    if(isset($_SESSION['user'])){

      $amountVideo=$this->videosDAO->amountVideosAccount($_SESSION['user']['id']);
      $this->set('amountVideo', $amountVideo['COUNT(path)']);

      $badges=$this->badgesDAO->selectByAccountId($_SESSION['user']['id']);

      if(!$badges['populair']){
        $likeAccountVideos=$this->video_reactionsDAO->numberLikesAccount($_SESSION['user']['id']);
        foreach($likeAccountVideos as $amountLikeVideo){
          if($amountLikeVideo['COUNT(*)']>=10){
            $this->badgesDAO->updateBadgePopulair($_SESSION['user']['id']);
            $_SESSION['info']='Badge verdient: "populair';         
          }
        }
      }

      $videosTime=$this->videosDAO->selectVideosByAccountTime($_SESSION['user']['id']);

      if(!$badges['ranglijst']){
        foreach($videosTime as $videoTime){
          if($rangPositions[$videoTime['id']]<=10){
            $this->badgesDAO->updateBadgeRanglijst($_SESSION['user']['id']);
            $_SESSION['info']='Badge verdient: Je staat in de ranglijst! ';
          }
        }
      }

      if(!$badges['nummer1']){
        foreach($videosTime as $videoTime){
          if($rangPositions[$videoTime['id']]===1){
            $this->badgesDAO->updateBadgeNummerEen($_SESSION['user']['id']);
            $_SESSION['info']='Badge verdient: NUMMER 1!';
          }
      }
      }



      if($sort==='id'){
        $videos=$this->videosDAO->selectVideosByAccountRecent($_SESSION['user']['id']);
      }
      if($sort==='time'){
        $videos=$this->videosDAO->selectVideosByAccountTime($_SESSION['user']['id']);       
      }

      $this->set('videos', $videos);
      
      $tips=$this->commentsDAO->getCommentsAccount($_SESSION['user']['id']);
      $this->set('tips', $tips);

      if(!$badges['coach']){
      $amountTips=$this->commentsDAO->commentsAccountCount($_SESSION['user']['id']);
      if(($amountTips['COUNT(*)'] ?? 0)>=10){
        $this->badgesDAO->updateBadgeCoach($_SESSION['user']['id']);
        $_SESSION['info']='Badge verdient: "Personal coach';
      }
      }

      $amountBadges=array(
        $badges['1poging'],$badges['10pogingen'],$badges['coach'],$badges['geeflike'], $badges['nummer1'], $badges['populair'], $badges['ranglijst'], $badges['tijd'], $badges['tip'], $badges['uitdager']
      );
      $this->set('badges', $badges);
      $this->set('amountBadges', array_sum($amountBadges));

      if(!empty($_POST)){
        if($_POST['action']==='add-like'){
          $data=array(
            'id_video'=> $_POST['id_video'],
            'id_account'=>$_POST['id_account']
          );
          $insertedReaction= $this->video_reactionsDAO->insert($data);
          if(!$badges['geeflike']){
            $this->badgesDAO->updateBadgeGeefLike($_SESSION['user']['id']);
            $_SESSION['info']='Badge verdient: "Geef Like';
          }
          header('location:index.php?page=feed&choice='.$_GET['choice']);
          exit();
        }
      }
    }
  }

    if($_GET['choice']==='video'){
      if(isset($_GET['id'])){
        $videoWatch=$this->videosDAO->selectById($_GET['id']);
        if(!empty($videoWatch)){
          $comments= $this->commentsDAO->getComments($_GET['id']);
          $videoOwner=$this->usersDAO->selectById($videoWatch['id_account']);
          $this->set('videoOwner', $videoOwner);
          $this->set('comments', $comments);         
          $this->set('videoWatch', $videoWatch);
        }else{
          header('Location: index.php?');
          exit();
        }
      }else{
        header('Location: index.php?');
        exit();
      }

      if(!empty($_POST)){

        if($_POST['action']==='add-comment'){
          if(empty($_POST['comment'])){
            $errors['comment']= 'vul een comment in';
          }
          if (empty($errors)) {
            $data = array(
              'id_video' => $_POST['id_video'],
              'comment' => $_POST['comment'],
              'username' => $_POST['username'],
              'id_account' => $_POST['id_account']
            );
            $insertedComment = $this->commentsDAO->insert($data);

            if(isset($_SESSION['user'])){
            $badges=$this->badgesDAO->selectByAccountId($_SESSION['user']['id']);
            if(!$badges['tip']){
              $this->badgesDAO->updateBadgeTip($_SESSION['user']['id']);
              $_SESSION['info']='Badge verdient: "Geef Tip';
            }
            }
            header('location:index.php?page=feed&choice=video&id='.$_GET['id']);
            exit();
          }
          $_SESSION['error'] = 'comment plaatsen mislukt';
          $this->set('errors', $errors);
        }
      }
    }

    if($_GET['choice']==='all'){
      $amountVideo=$this->videosDAO->amountVideos();
      $this->set('amountVideo', $amountVideo['COUNT(path)']);

      if($sort==='id'){
        $videos=$this->videosDAO->selectAllVideosRecent();
      }
      if($sort==='time'){
        $videos=$this->videosDAO->selectAllVideosTime();       
      }

      if($sort==='popular'){
        $videos = $this->videosDAO->selectAllVideosPopular();
      }
      $this->set('videos', $videos);
      if(!empty($_POST)){
      if($_POST['action']==='add-like'){
          $data=array(
            'id_video'=> $_POST['id_video'],
            'id_account'=>$_POST['id_account']
          );
          $insertedReaction= $this->video_reactionsDAO->insert($data);
          if(isset($_SESSION['user'])){
            $badges=$this->badgesDAO->selectByAccountId($_SESSION['user']['id']);
            if(!$badges['geeflike']){
              $this->badgesDAO->updateBadgeGeefLike($_SESSION['user']['id']);
              $_SESSION['info']='Badge verdient: "Geef Like';
            }
          }

          header('location:index.php?page=feed&choice='.$_GET['choice']);
          exit();
        }
      }
    }
  }

  
  private function feedInput(array $data): ?array {
    $action = $data['action'] ?? null;
    if (!in_array($action, ['add-like', 'add-comment'], true)) {
      return null;
    }
    $id = filter_var($data['id_video'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if (!$id || !$this->videosDAO->selectById($id)) {
      return null;
    }
    if ($action === 'add-comment') {
      $comment = $data['comment'] ?? null;
      if (!is_string($comment) || trim($comment) === '' || strlen($comment) > 2000) {
        return null;
      }
      $data['comment'] = trim($comment);
    }
    $data['id_video'] = $id;
    $data['id_account'] = $_SESSION['user']['id'] ?? 1;
    $data['username'] = $_SESSION['user']['username'] ?? 'gast';
    return $data;
  }

  public function upload(){
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }

    $upload = $_FILES['video'] ?? null;
    if (!$upload || $upload['error'] !== UPLOAD_ERR_OK || $upload['size'] > 32 * 1024 * 1024) {
      $this->set('error', 'Kies een MP4-video van maximaal 32 MB.');
      return;
    }
    $time = filter_input(INPUT_POST, 'time', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if (!$time || (new finfo(FILEINFO_MIME_TYPE))->file($upload['tmp_name']) !== 'video/mp4') {
      $this->set('error', 'Kies een MP4-video en vul een geldige tijd in seconden in.');
      return;
    }

    $path = 'assets/uploads/' . bin2hex(random_bytes(16)) . '.mp4';
    $target = dirname(__DIR__) . '/' . $path;
    if (!move_uploaded_file($upload['tmp_name'], $target)) {
      $this->set('error', 'De video kon niet worden opgeslagen.');
      return;
    }
    chmod($target, 0644);
    try {
      $this->videosDAO->insert([
        'path' => $path,
        'time' => $time,
        'id_account' => $_SESSION['user']['id'] ?? 1,
        'path_thumbnail' => 0
      ]);
    } catch (PDOException $error) {
      unlink($target);
      error_log($error->getMessage());
      $this->set('error', 'De poging kon niet worden opgeslagen.');
      return;
    }

    if(isset($_SESSION['user'])){
      $videosTime=$this->videosDAO->selectAllVideosTime();
      $rangPosition=array();
      foreach ($videosTime as $key=>$videoTime){
        $rangPosition[$videoTime['id']]= $key+1;
      }

      $badges=$this->badgesDAO->selectByAccountId($_SESSION['user']['id']);
      if(!$badges['tijd']&&$time>=1600){
        $this->badgesDAO->updateBadgeTijd($_SESSION['user']['id']);
        $_SESSION['info']='Badge verdient: "Lange adem';
      }

      if(!$badges['1poging']){
        $this->badgesDAO->updateBadgePoging($_SESSION['user']['id']);
        $_SESSION['info']='Badge verdient: "Eerste poging';
      }

      if(!$badges['10pogingen']){
        $amountUploads=$this->videosDAO->amountVideosAccount($_SESSION['user']['id']);
        if($amountUploads['COUNT(path)']>=10){
          $this->badgesDAO->updateBadgePogingen($_SESSION['user']['id']);
          $_SESSION['info']='Badge verdient: "upload 10 pogingen';
        }
      }

      $videosTime=$this->videosDAO->selectVideosByAccountTime($_SESSION['user']['id']);

      if(!$badges['ranglijst']){
        foreach($videosTime as $videoTime){
          if($rangPosition[$videoTime['id']]<=10){
            $this->badgesDAO->updateBadgeRanglijst($_SESSION['user']['id']);
            $_SESSION['info']='Badge verdient: Je staat in de ranglijst!';
          }
        }

      }

      if(!$badges['nummer1']){
        foreach($videosTime as $videoTime){
          if($rangPosition[$videoTime['id']]===1){
            $this->badgesDAO->updateBadgeNummerEen($_SESSION['user']['id']);
            $_SESSION['info']='Badge verdient: "NUMMER 1!';
          }
        }
      }
    }
    header('Location: index.php?page=feed&choice=all', true, 303);
    exit();
  }
}
