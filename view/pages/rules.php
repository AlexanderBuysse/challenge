<section class="rules">
    <h2 class=rules-title>regels</h2>
    <svg class="title-line" width="650" height="9" viewBox="0 0 690 9">
        <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="9"/>
    </svg>     
    <p class="rules-subtitle">Voor je de koning en koningin kan helpen moet je eerst leren hoe je moelleux kan maken.</p>
    <article class="rules__article">
        <h3 class="rules__article-title">stap 1: kies je niveau</h3>
        <div class="rules__article-buttons">
            <a href="index.php?page=rules&choice=beginner" class="rules__article-button"><img class="article__button-img" src="assets/img/prinsesknop.svg" alt="knop prinses"><span class="article__button-text  margin">ik wil nog oefenen</span></a>
            <a href="index.php?page=rules&choice=advanced" class="rules__article-button"><img class="article__button-img" src="assets/img/kokknop.svg" alt="knop kok"><span class="article__button-text marginleft">ik kan al moelleux bakken</span></a>
        </div>
    </article>
    <?php if(isset($_GET['choice']))
        if($_GET['choice']==='advanced'):
    ?>
    <article class="rules__article">
        <h3 class="rules__article-title">stap 2: lees 8 gouden regels</h3>
        <div class="rules__rule-board">
            <ul class="rules__list">
                <li>Je moelleux mag niet uit elkaar vallen</li>
                <li>Je moulleux mag niet verbrand zijn</li>
                <li>Je moet het hele proces filmen</li>
                <li>Je mag alles klaarleggen maar alles blijft nog in de verpakking</li>
            </ul>
            <svg class="rules__list-svg" width="15" height="388.012" viewBox="0 0 9.512 388.012"><line x1="0" y2="379" transform="translate(4.506 4.506)" fill="none" stroke="#a23740" stroke-linecap="round" stroke-width="9"/></svg>
            <ul class="rules__list">
                <li>Je moet het recept volgen van hieronder</li>
                <li>Je mag de oven op voorhand opwarmen</li>
                <li>Het moet eetbaar zijn</li>
                <li>De tijd start vanaf je een ingrediënt aanraakt</li>
            </ul>
        </div>
    </article>
    <article class="rules__article ">
        <h3 class="rules__article-title">stap 3: de ingrediënten</h3>
        <div class="rules__ingredients">
            <div class="rules__ingredient">
                <p class="ingredient-text">2 eieren</p>
                <img class="ingredient-img" src="assets/img/ingredienten/eieren.svg" alt="eieren">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">Weegschaal</p>
                <img class="ingredient-img" src="assets/img/ingredienten/weegschaal.svg" alt="weegschaal">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">20g bloem</p>
                <img class="ingredient-img" src="assets/img/ingredienten/bloem.svg" alt="bloem">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">125g boter</p>
                <img class="ingredient-img" src="assets/img/ingredienten/boter.svg" alt="boter">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">60g rietsuiker</p>
                <img class="ingredient-img" src="assets/img/ingredienten/rietsuiker.svg" alt="rietsuiker">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">Mengkom</p>
                <img class="ingredient-img" src="assets/img/ingredienten/pot.svg" alt="pot">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">1 ei-geel</p>
                <img class="ingredient-img" src="assets/img/ingredienten/ei-geel.svg" alt="ei geel">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">125g chocolade</p>
                <img class="ingredient-img" src="assets/img/ingredienten/chocolade.svg" alt="chocolade">
            </div>
        </div>
        
    </article>
    <article  class="rules__article">
        <h3 class="rules__article-title">stap 4: recept bereiding</h3>
        <div class="rules__recept">
            <ol class="recept-list">
                <li class="recept-listitem">Verwarm de oven voor op 180 ° C.</li>
                <li class="recept-listitem">Klop de eieren en de dooier met de suiker.</li>
                <li class="recept-listitem">Laat de chocolade en de boter smelten in een warmwaterbad of in de magnetron. Roer goed glad. Schenk er de helft van het eimengsel bij. Roer glad.</li>
                <li class="recept-listitem">Voeg het chocolademengsel aan de rest van het eimengsel toe. Meng voorzichtig. Strooi er de gezeefde bloem bij. Spatel luchtig om en om tot de bloem volledig opgenomen is.</li>
                <li class="recept-listitem">Vet de 6 ovenschaaltjes goed in en bestuif ze met bloem. Verdeel het chocolademengsel over de schaaltjes.</li>
                <li class="recept-listitem">Bak 8 minuten in het midden van de oven. Serveer meteen.</li>
            </ol>
            <div class="rules__recept-img">
                <img src="assets/img/moelleuxafbeelding.svg" alt="moelleux">
                <div class="recept__img-tip">
                    <h4 class="recept__img-title">tip</h4>
                    <p class="recept__img-text">Moelleux is pittig om te maken, een goede baktijd zal hier veel in helpen.</b></p>
                </div>
            </div>
        </div>
    </article>
</section>
<section class="section__six">
    <h2 class="semi-subtitle subtitle six-larger">breek het wereld record</h2>
    <div class="section__six-time">
        <img src="assets/img/klok.svg" alt="klok" width="268" height="268">
        <p class="time-title">wr 12m 09s</p>
        <p class="time-text">Je hebt nu alles om de koning en koningin te helpen, upload nu een recordpoging en wordt misschien de beste. </p>
    </div>
    <a href="index.php?page=upload" class="button-upload"><span class="upload-plus">+</span> <svg width="5" height="63" viewBox="0 0 4.5 90.5"><line y2="86" transform="translate(2.25 2.25)" fill="none" stroke="#D84955" stroke-linecap="round" stroke-width="5"/></svg> <span>uploaden</span></a>
</section>
<?php else:?>


<article class="rules__article ">
        <h3 class="rules__article-title">stap 2: de ingrediënten</h3>
        <div class="rules__ingredients">
            <div class="rules__ingredient">
                <p class="ingredient-text">1 ei</p>
                <img class="ingredient-img" src="assets/img/ei.svg" alt="eieren">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">Weegschaal</p>
                <img class="ingredient-img" src="assets/img/ingredienten/weegschaal.svg" alt="weegschaal">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">175g bloem</p>
                <img class="ingredient-img" src="assets/img/ingredienten/bloem.svg" alt="bloem">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">100g boter</p>
                <img class="ingredient-img" src="assets/img/ingredienten/boter.svg" alt="boter">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">50g kristalsuiker</p>
                <img class="ingredient-img" src="assets/img/ingredienten/rietsuiker.svg" alt="rietsuiker">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">Mengkom</p>
                <img class="ingredient-img" src="assets/img/ingredienten/pot.svg" alt="pot">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">100g kandijsuiker</p>
                <img class="ingredient-img" src="assets/img/suiker.svg" alt="ei geel">
            </div>
            <div class="rules__ingredient">
                <p class="ingredient-text">200g chocolade</p>
                <img class="ingredient-img" src="assets/img/ingredienten/chocolade.svg" alt="chocolade">
            </div>
        </div>
        
    </article>
    <article  class="rules__article">
        <h3 class="rules__article-title">stap 3: recept bereiding</h3>
        <div class="rules__recept">
            <ol class="recept-list">
                <li class="recept-listitem">Verwarm de oven voor op 180° C. Smelt de boter en klop samen met de kristal- en de kandijsuiker tot een schuimige massa.</li>
                <li class="recept-listitem"> Doe er het ei, het bakpoeder en het vanillearoma bij. Meng goed. Doe er als laatste de bloem bij. Meng tot een glad deeg en doe er dan de chocoladepellets bij.</li>
                <li class="recept-listitem">Vorm met behulp van 2 eetlepels hoopjes en verdeel zo het deeg in kleine porties. Duw de hoopjes plat en versier met de smarties.</li>
                <li class="recept-listitem">Leg de koekjes op een bakvorm bekleed met bakpapier en bak ze in 10 tot 12 minuten goudbruin in de voorverwarmde oven. Laat ze afkoelen op een rooster.</li>
            </ol>
            <div class="rules__recept-img">
                <img src="assets/img/cookiesafbeelding.svg" alt="coockie">
                <div class="recept__img-tip margin-bottom">
                    <h4 class="recept__img-title">tip</h4>
                    <p class="recept__img-text">als je koekjes goed kan bakken dan is de stap naar moelleuxs bakken minder groot.</p>
                </div>
            </div>
        </div>
    </article>
</section>
<section class="section__six">
    <h2 class="semi-subtitle subtitle six-larger">oefen voor het wereldrecord</h2>
    <div class="section__six-time">
        <img src="assets/img/klok.svg" alt="klok" width="268" height="268">
        <p class="time-title">wr 12m 09s</p>
        <p class="time-text">Je kan nu goed koekjes bakken. Oefen nu op moelleuxs bakken en maak kans om in de hall of fame terecht te komen</p>
    </div>
    <a href="index.php?page=rules&choice=advanced" class="button-upload">naar gevorderd</a>
</section>
<?php endif?>