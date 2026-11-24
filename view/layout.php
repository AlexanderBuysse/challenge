<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/viewport.js"></script>
    <title>Snel Bakkers</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/xtt5bbq.css">
    <link rel="icon" href="assets/img/kroon.svg">
    <link rel="stylesheet" href="school-intro.css">
    <script src="school-intro.js?v=demo" defer></script>
</head>

<body>
<div class="desktop-layout">
    <header class="header">
    <h1 class="hidden">snelheid bakkers</h1>
        <nav class="navi">
            <ul class="navi__list">
                <li class="navi__list-item"><a href="index.php" class="home-button"><img src="assets/img/kroon.svg" alt="kroontje"> <span class="home-text">SB</span></a></li>
                <li class="navi__list-item">
                    <ul class="navi__list-list subtitle">
                        <li class="list-item"><a href="index.php?page=rules"><svg class="button-redshadow" height="59.726" viewBox="0 0 51.5 59.726" width="51.5" xmlns="http://www.w3.org/2000/svg"><g fill="#f9cc52" stroke="#d84955" transform="translate(4.5 4.5)"><rect height="50.726" rx="8.066" stroke-miterlimit="10" stroke-width="9" width="42.5"/><g stroke-linecap="round" stroke-width="4.5"><path d="m19.021 16.291h15.602" stroke-miterlimit="10"/><path d="m19.464 27.435h15.602" stroke-miterlimit="10"/><path d="m19.464 38.022h15.602" stroke-miterlimit="10"/><path d="m2700.384 1984.343a17.808 17.808 0 0 0 2.786 1.672s2.786-5.015 4.458-5.015" stroke-linejoin="round" transform="translate(-2692 -1968.774)"/><path d="m2699.827 1996.488a17.874 17.874 0 0 0 2.786 1.671s2.786-5.015 4.458-5.015" stroke-linejoin="round" transform="translate(-2692 -1968.774)"/><path d="m2700.827 2006.518a17.9 17.9 0 0 0 2.786 1.672s2.786-5.015 4.458-5.015" stroke-linejoin="round" transform="translate(-2692 -1968.774)"/></g></g></svg></a><p>regels</p></li>
                        <li></li>
                        <li class="list-item"><a href="index.php?page=feed&choice=all"><img class="button-redshadow" src="assets/img/knopfeed.svg" alt="knop feed"></a><p>feed</p></li>
                        <li></li>
                        <li class="list-item"><a href="index.php?#fourth"><img class="button-redshadow" src="assets/img/knophof.svg" alt="knop HOF"></a><p>hall of fame</p></li>
                    </ul>
                </li>
                
                <li class="navi__list-item">
                    <button type="button" class="register-button bruh" data-demo-action>Inloggen</button>
                    <button type="button" class="register-button bruh" data-demo-action>Maak een account</button>
                </li>
            </ul>
        </nav>
    </header>
    
    <main><?= $content ?></main>
</div>

    <dialog class="school-intro" data-project="challenge" aria-labelledby="school-intro-title" aria-describedby="school-intro-description">
        <h2 id="school-intro-title">Snel Bakkers</h2>
        <p id="school-intro-description">Dit is een schoolproject uit 2020 over een wedstrijd moelleux bakken. Het ontwerp is gemaakt voor een vaste desktopbreedte. Op je telefoon zie je dezelfde indeling verkleind. Je kunt de voorbeeldpogingen bekijken en sorteren.</p>
        <form method="dialog">
            <button type="submit" autofocus>Bekijk het project</button>
        </form>
    </dialog>

    <dialog class="school-intro" id="demo-action" aria-labelledby="demo-action-title" aria-describedby="demo-action-description" <?= $actionDisabled ? 'data-show-on-entry' : '' ?>>
        <h2 id="demo-action-title">Deze actie is uitgeschakeld</h2>
        <p id="demo-action-description">Snel Bakkers is een oud schoolproject. Om de hosting te beschermen staat de site in demomodus. Je kunt de voorbeeldpogingen bekijken en sorteren. Uploaden, inloggen, accounts aanmaken, liken en reageren zijn uitgeschakeld.</p>
        <form method="dialog">
            <button type="submit" autofocus>Verder kijken</button>
        </form>
    </dialog>
</body>

</html>