<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>snel bakkers  -<?php if(isset($_GET['page'])){echo $_GET['page'];}?></title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/xtt5bbq.css">
    <link rel="icon" href="assets/img/kroontje.svg">
</head>

<body>
    <header class="header">
    <h1 class="hidden">snelheid bakkers</h1>
        <nav class="navi">
            <ul class="navi__list">
                <li class="navi__list-item"><a href="index.php?page=index" class="home-button"><img src="assets/img/kroontje.svg" alt="kroontje"> <span class="home-text">SB</span></a></li>
                <?php if($_GET['page']!=='login'):?>
                <li class="navi__list-item">
                    <ul class="navi__list-list subtitle">
                        <li class="list-item"><a href="index.php?page=rules"><svg class="button-redshadow" height="59.726" viewBox="0 0 51.5 59.726" width="51.5" xmlns="http://www.w3.org/2000/svg"><g fill="#f9cc52" stroke="#d84955" transform="translate(4.5 4.5)"><rect height="50.726" rx="8.066" stroke-miterlimit="10" stroke-width="9" width="42.5"/><g stroke-linecap="round" stroke-width="4.5"><path d="m19.021 16.291h15.602" stroke-miterlimit="10"/><path d="m19.464 27.435h15.602" stroke-miterlimit="10"/><path d="m19.464 38.022h15.602" stroke-miterlimit="10"/><path d="m2700.384 1984.343a17.808 17.808 0 0 0 2.786 1.672s2.786-5.015 4.458-5.015" stroke-linejoin="round" transform="translate(-2692 -1968.774)"/><path d="m2699.827 1996.488a17.874 17.874 0 0 0 2.786 1.671s2.786-5.015 4.458-5.015" stroke-linejoin="round" transform="translate(-2692 -1968.774)"/><path d="m2700.827 2006.518a17.9 17.9 0 0 0 2.786 1.672s2.786-5.015 4.458-5.015" stroke-linejoin="round" transform="translate(-2692 -1968.774)"/></g></g></svg></a><p>regels</p></li>
                        <li><img src="assets/img/lijn.svg" alt="lijn"></li>
                        <li class="list-item"><a href="index.php?page=feed&choice=all"><img class="button-redshadow" src="assets/img/knopfeed.svg" alt="knop feed"></a><p>feed</p></li>
                        <li><img src="assets/img/lijn.svg" alt="lijn"></li>
                        <li class="list-item"><a href="index.php?#fourth"><img class="button-redshadow" src="assets/img/knophof.svg" alt="knop HOF"></a><p>hall of fame</p></li>
                        <?php if(!empty($_SESSION['user'])):?>
                        <li><img src="assets/img/lijn.svg" alt="lijn"></li>
                        <li class="list-item log-out"><a href="index.php?page=logout" class="red button-feed" >uitloggen</a></li>
                        <?php endif;?>
                    </ul>
                </li>
                
                <li class="navi__list-item"><a href="<?php if(!empty($_SESSION['user'])) {echo 'index.php?page=feed&choice=personal&id='.$_SESSION['user']['id'];} else {echo 'index.php?page=login';}?>" class="register-button bruh"><?php if(!empty($_SESSION['user'])) {echo 'mijn pagina';} else {echo 'maak een account';}?></a></li>
                <?php endif;?>
            </ul>
        </nav>
    </header>
    
    <main>
    <div class="container">
        <?php if (!empty($_SESSION['info'])): ?>
            <div class="info">
                <span class="closebtn">&times;</span> 
                <p><?php echo $_SESSION['info']; ?></p>
            </div>
        <?php endif; ?>
    </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="error-message">
                <span class="closebtn">&times;</span> 
                <p><?php echo $_SESSION['error']; ?></p>
            </div>
        <?php endif; ?>
        <?php echo $content; ?>
    </main>

    <script src="js/script.js"></script>
</body>

</html>