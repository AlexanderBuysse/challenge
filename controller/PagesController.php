<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../dao/usersDAO.php';
require_once __DIR__ . '/../dao/badgesDAO.php';
require_once __DIR__ . '/../dao/videosDAO.php';
require_once __DIR__ . '/../dao/commentsDAO.php';
require_once __DIR__ . '/../dao/video_reactionsDAO.php';


class PagesController extends Controller {


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
    if(!empty($_POST)){
      $errors=array();

      if($_POST['action']==='register'){
        if(empty($_POST['username'])){
          $errors['username']= 'vul een gebruikersnaam in';
        } else{
          $exciting=$this->usersDAO->selectByUsername($_POST['username']);
          if(!empty($exciting)){
            $errors['username']= 'deze gebruikersnaam bestaat al';
          }
        }

      if (empty($_POST['password'])) {
        $errors['password'] = 'geef een wachtwoord op';
      }
      if ($_POST['confirm_password'] != $_POST['password']) {
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
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $existing = $this->usersDAO->selectByUsername($_POST['username']);
        if (!empty($existing)) {
          if (password_verify($_POST['password'], $existing['password'])) {
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
    if(!isset($_GET['choice'])){
      header('Location: index.php?');
      exit();
    }

    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json") {

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true); // JSON omzetten naar assoc array

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
        if(empty($data['comment'])){
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

    $sort='id';
    if(isset($_GET['sort'])){
      $sort= $_GET['sort'];
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
          if($rangPosition[$videoTime['id']]<=10){
            $this->badgesDAO->updateBadgeRanglijst($_SESSION['user']['id']);
            $_SESSION['info']='Badge verdient: Je staat in de ranglijst! ';
          }
        }
      }

      if(!$badges['nummer1']){
        foreach($videosTime as $videoTime){
          if($rangPosition[$videoTime['id']]===1){
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
      if($amountTips['COUNT(*)']>=10){
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

      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if ($contentType === "application/json") {

        $content = trim(file_get_contents("php://input"));
        $data = json_decode($content, true); // JSON omzetten naar assoc array

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
        $popularvideos=$this->video_reactionsDAO->numberLikesPopular();
        $videos=array();
        foreach($popularvideos as $video){
          $videos[]=$this->videosDAO->selectById($video['id_video']);
        }  
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

  
  public function upload(){

    // variabele om foutmelding bij te houden
    $error = '';

    // controleer of er iets in de $_POST zit
    if(!empty($_POST['action'])){
      // controleer of het wel om het juiste formulier gaat
      if($_POST['action'] == 'add-video') {
        // controleren of er een bestand werd geselecteerd
        if (empty($_FILES['video']) || !empty($_FILES['video']['error'])) {
          $error = 'Gelieve een bestand te selecteren';
        }

        if(empty($error)){
          // controleer of het een afbeelding is van het type jpg, png of gif
          $whitelist_type = array('video/mp4');
          if(!in_array($_FILES['video']['type'], $whitelist_type)){
              $error = 'Gelieve een jpeg, png of gif te selecteren';
          }
        }

        /*if(empty($error)){
          // controleer de afmetingen van het bestand: pas deze gerust aan voor je eigen project
          // width: 270
          // height: 480
          $size = getimagesize($_FILES['image']['tmp_name']);
          if ($size[0] < 270 || $size[1] < 480) {
              $error = 'De afbeelding moet minimum 270x480 pixels groot zijn';
          }
        }*/


        if(empty($error)){
          // map met een random naam aanmaken voor de upload: redelijk zeker dat er geen conflict is met andere uploads
          $projectFolder = realpath(__DIR__);
          $targetFolder = $projectFolder . '/../assets/uploads';
          $targetFolder = tempnam($targetFolder, '');
          unlink($targetFolder);
          mkdir($targetFolder, 0777, true);
          $targetFileName = $targetFolder . '/' . $_FILES['video']['name'];

          // via de functie _resizeAndCrop() de afbeelding croppen en resizen tot de gevraagde afmeting
          // pas gerust aan in je eigen project
          $video = $_FILES["video"]["name"];
 
          $command ="/usr/local/bin/ffmpeg -i " . $video . " -vf fps=1/60 thumbnail-%03d.png";
          system($command);
          
          //$this->_resizeAndCrop($_FILES['video']['tmp_name'], $targetFileName, 480, 480);

          $relativeFileName = substr($targetFileName, 1 + strlen($projectFolder));
          move_uploaded_file($_FILES["video"]["tmp_name"], "assets/uplo" . $relativeFileName);

          $data = array(
              'path' => 'assets/uplo'.$relativeFileName,
              'time' => $_POST['time'],
              'id_account' => $_POST['id_account'],
              'path_thumbnail'=>$_POST['path_thumbnail']
          );


          }
          if(!empty($error)){
          $this->set('error', $error);
          }else{
          $insertedVideo = $this->videosDAO->insert($data);
          if(isset($_SESSION['user'])){
            $likes= $this->video_reactionsDAO->numberLikes();
            $keyVideoIdLikes = array();
            foreach ($likes as $like){
            $keyVideoIdLikes[$like['id_video']]= $like['COUNT(*)'];
            }

            $videosTime=$this->videosDAO->selectAllVideosTime();
            $rangPosition=array();
            foreach ($videosTime as $key=>$videoTime){
              $rangPosition[$videoTime['id']]= $key+1;
            }

            $badges=$this->badgesDAO->selectByAccountId($_SESSION['user']['id']);
            if(!$badges['tijd']&&$_POST['time']>=1600){
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

            if(!$badges['nummer1']){
              foreach($videosTime as $videoTime){
                if($rangPosition[$videoTime['id']]===1){
                  $this->badgesDAO->updateBadgeNummerEen($_SESSION['user']['id']);
                  $_SESSION['info']='Badge verdient: "NUMMER 1!';
                }
              }
            }
          }
          }
            
          header('Location: index.php?');
          exit();
        }

      }
    }
  }

}
