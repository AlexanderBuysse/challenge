<div class="feed">
   <section class="feed__section-one">
        <div class="section-one__header">
            <div>
                <?php if(isset($_SESSION['user'])&&$_GET['choice']==='personal'):?>
                <h2 class="red-word"><?php echo $_SESSION['user']['username']?></h2>
                <?php elseif($_GET['choice']==='all'):?>
                <h2 class="red-word">alle pogingen</h2>
                <?php elseif($_GET['choice']==='video'):?>
                <h2 class="red-word">poging: <?php echo $videoOwner['username']?></h2>
                <?php endif;?>
                <svg class="title-line" width="580" height="9" viewBox="0 0 690 9">
                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="9"/>
                </svg>     
            </div>
            <?php if(isset($_SESSION['user'])&&$_GET['choice']==='personal'):?>
                <p class="button-feed">Aantal badges: <?php echo $amountBadges?></p>
            <?php else:?>
                <a href="index.php?page=upload" class="button-upload"><span class="upload-plus">+</span> <svg width="5" height="63" viewBox="0 0 4.5 90.5"><line y2="86" transform="translate(2.25 2.25)" fill="none" stroke="#D84955" stroke-linecap="round" stroke-width="5"/></svg> <span>uploaden</span></a>
            <?php endif?>
        </div>
        <div class="middle feed-videos">
            <?php if($_GET['choice']!=='video'):?>
            <div class="feed-infobar">
                <p class="feed-text">totaal pogingen: <?php echo $amountVideo?></p>
                <form action="index.php?page=feed" method="get">
                    <input type="hidden" name="page" value="feed">
                    <input type="hidden" name="choice" value="<?php echo $_GET['choice']?>">
                    <label> sorteer op:
                        <select name="sort">
                            <option value="id">--------</option>
                            <option <?php if(isset($_GET['sort'])&&$_GET['sort']==='id') echo 'selected';?> value="id">recent</option>
                            <option <?php if(isset($_GET['sort'])&&$_GET['sort']==='time') echo 'selected';?> value="time">snelst</option>
                            <?php if($_GET['choice']==='all'):?>
                            <option <?php if(isset($_GET['sort'])&&$_GET['sort']==='popular') echo 'selected';?> value="popular">populairst</option>
                            <?php endif;?>
                        </select>
                    </label>
                    <input type="submit" class="button-like" value="sorteer">
                </form>
            </div>
            <?php endif;?>
            <div class="feed-cards">
                <?php if($_GET['choice']==='all'):?>
                <?php foreach($videos as $video):?>
                <article class="feed-card">
                    <h3 class="hidden">video</h3>
                    <div>
                        <a href="index.php?page=feed&choice=video&id=<?php echo $video['id']?>" class="video-play">
                            <img class="video-thumbnail" src="assets/img/placeholder.svg" alt="video placeholder">
                            <p class="button-place">Plaats: <?php echo $rangPosition[$video['id']]?></p>
                            <img class="video-placeholder" src="assets/img/rodedriehoek.svg" alt="driehoek">
                        </a>
                    </div>
                    <div class="card-info">
                        <p>Tijd: <?php echo $video['time']?>s</p>
                        <form action="index.php?page=feed&choice=all" class="form-like" method="POST">
                            <input type="hidden" name="action" value="add-like">
                            <input type="hidden" name="id_video" value="<?php echo $video['id']?>">
                            <input type="hidden" name="id_account" value="<?php if(isset($_SESSION['user'])){echo $_SESSION['user']['id'];}else{echo 1;}?>">
                            <div class="section-like">
                                <label>
                                    <p class="button-like button-like1"><em class="like-amount"><?php if(!empty($allLikes[$video['id']])){echo $allLikes[$video['id']];}else{echo 0;}?></em><img src="assets/img/kroontje.svg" alt="kroontje" width="40" height="20"></p>
                                    <input class="like-check rating__js opacity" type="checkbox" id="like" name="like" value="1" required>
                                </label>
                                
                            </div>
                            <input class="button-like submit" type="submit" value="bevestig like">
                        </form>
                    </div>
                </article>
                <?php endforeach;?>
                <?php elseif(isset($_SESSION['user'])&&$_GET['choice']==='personal'):?>
                <?php foreach($videos as $video):?>
                <article class="feed-card">
                    <h3 class="hidden">video</h3>
                    <div>
                        <a href="index.php?page=feed&choice=video&id=<?php echo $video['id']?>" class="video-play">
                            <img class="video-thumbnail" src="assets/img/placeholder.svg" alt="video placeholder">
                            <p class="button-place">Plaats: <?php echo $rangPosition[$video['id']]?></p>
                            <img class="video-placeholder" src="assets/img/rodedriehoek.svg" alt="driehoek">
                        </a>
                    </div>
                    <div class="card-info">
                        <p>Tijd: <?php echo $video['time']?>s</p>
                        <form action="index.php?page=feed&choice=personal" class="form-like" method="POST">
                            <input type="hidden" name="action" value="add-like">
                            <input type="hidden" name="id_video" value="<?php echo $video['id']?>">
                            <input type="hidden" name="id_account" value="<?php echo $_SESSION['user']['id']?>">
                            <div class="section-like">
                                <label>
                                    <p class="button-like button-like1"><em class="like-amount"><?php if(!empty($allLikes[$video['id']])){echo $allLikes[$video['id']];}else{echo 0;}?></em><img src="assets/img/kroontje.svg" alt="kroontje" width="40" height="20"></p>
                                    <input class="like-check rating__js opacity" type="checkbox" id="like" name="like" value="1" required>
                                </label>
                            </div>
                            <input class="button-like submit" type="submit" value="bevestig like">
                        </form>
                    </div>
                </article>
                <?php endforeach;?>
                <a href="index.php?page=upload" class="feed-card upload-button">
                    <h3 class="hidden">upload</h3>
                    <img src="assets/img/plus.svg" alt="plus">
                    <p>nieuwe poging</p>
                </a>
                <?php elseif($_GET['choice']==='video'):?>
                    <video width="1000" height="600" controls>
                        <source src="<?php echo $videoWatch['path']?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php if($_GET['choice']==='personal'):?>
        <aside class="aside">
            <section class="aside__section">
                <h2 class="aside__title">coach</h2>
                <div class="aside__text">
                    <?php if(!empty($tips)):?>
                        <ul class="ranglist-comments tips-list">
                            <?php foreach($tips as $tip):?>
                                <li class="ranglist-comment"><span class="subtitle"><?php echo $tip['username']?>: </span><?php echo $tip['comment']?></li>
                            <?php endforeach;?>
                        </ul>
                    <?php else:?>
                        <img src="assets/img/coach.svg" alt="coach">
                        <p>tips van andere</p>
                    <?php endif;?>
                </div>
            </section>
            <section class="aside__section">
                <h2 class="aside__title">badges</h2>
                <div class="aside__badges">
                    <img class="<?php if($badges['1poging']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/1poging.svg" alt="badge" width="65">
                    <img class="<?php if($badges['10pogingen']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/10pogingen.svg" alt="badge" width="65">
                    <img class="<?php if($badges['nummer1']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/nummer1.svg" alt="badge" width="65">
                    <img class="<?php if($badges['geeflike']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/geeflike.svg" alt="badge" width="65">
                    <img class="<?php if($badges['tip']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/tip.svg" alt="badge" width="65">
                    <img class="<?php if($badges['coach']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/coach.svg" alt="badge" width="65">
                    <img class="<?php if($badges['populair']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/populair.svg" alt="badge" width="65">
                    <img class="<?php if($badges['uitdager']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/uitdager.svg" alt="badge" width="65">
                    <img class="<?php if($badges['ranglijst']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/ranglijst.svg" alt="badge" width="65">
                    <img class="<?php if($badges['tijd']){echo 'opacity100';}else{echo 'opacity30';}?>" src="assets/img/badges/tijd.svg" alt="badge" width="65">
                </div>
                <button id="myBtn" class="button-badge">detail badges</button>
            </section>
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <div class="badge__header">
                            <span class="close"> sluit &times;</span>
                            <h2 class=header__title>badges</h2>
                        </div>
                        <div class="badges__container">
                            <div class="badge">
                                <img src="assets/img/badges/1poging.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">debut</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Upload je eerste recordpoging</p>
                            </div>
                            <div class="badge">
                                <img src="assets/img/badges/10pogingen.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">ervaren</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Upload tien recordpogingen</p>
                            </div>
                            <div class="badge">
                                <img src="assets/img/badges/nummer1.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">koning</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Sta op nummer 1 in de ranglijst</p>
                            </div>
                            <div class="badge">
                                <img src="assets/img/badges/geeflike.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">like gever</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Like een video</p>
                            </div>
                            <div class="badge">
                                <img src="assets/img/badges/tip.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">tip gever</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Geef een tip</p>
                            </div>
                            <div class="badge">
                                <img src="assets/img/badges/populair.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">populairtje</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Krijg 10 likes</p>
                            </div>
                            <div class="badge">
                                <img src="assets/img/badges/coach.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">ps coach</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Geef 10 tips aan anderen</p>
                            </div>
                            <div class="badge">
                                <img src="assets/img/badges/ranglijst.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">een begin</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Bemachtig een plaats in de top 10</p>
                            </div>
                            <div class="badge">
                                <img src="assets/img/badges/tijd.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">lange adem</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Upload een video van 30 minuiten</p>
                            </div>
                            <div class="badge">
                                <img src="assets/img/badges/uitdager.svg" alt="badge" width="170">
                                <h3 class="badge-title subtitle">uitdager</h3>
                                <svg width="100" height="30" viewBox="0 0 690 9">
                                    <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="30"/>
                                </svg> 
                                <p class="badge-text">Daag een vriend uit</p>
                            </div>
                        </div>
                    </div>
                </div>
        </aside>
    <?php elseif($_GET['choice']==='all'):?>
        <aside class="aside">
            <section class="aside__ranglist">
                <h2 class="aside__title">ranglijst</h2>
                <div class=ranglist-persons>
                    <div class="ranglist-person">
                        <?php foreach($rangTen as $key=>$rang): ?>
                        <div class="ranglist-all">
                            <div>
                                <p class="ranglist__text-time"><?php echo $rang['time']?> seconden</p>
                                <h3 class="ranglist__text-name"><?php echo $rang['username']?></h3>
                            </div>
                            <?php if($key===0):?>
                            <img src="assets/img/kroon.svg" alt="kroon">
                            <?php else:?>
                            <p><?php echo $key+1?></p>
                            <?php endif;?>
                        </div>
                        <svg class="title-line" width="360" height="15" viewBox="0 0 690 9">
                            <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="10"/>
                        </svg> 
                        <?php endforeach;?>
                    </div>
                </div>
            </section>
        </aside>
    <?php elseif($_GET['choice']==='video'):?>
        <aside class="aside">
            <section class="aside__ranglist">
                <h2 class="aside__title">TIPs</h2>
                <form action="index.php?page=feed&choice=video&id=<?php echo $_GET['id']?>" method="post" class="form__comment">
                    <p class=error><?php if(!empty($errors['comment'])) echo $errors['comment'];?></p>
                    <div class="form-comment">
                        <input type="text" name="comment" class="input-field input" placeholder="geef je tip" minlength="3" maxlength="300" required>
                        <input type="submit" class="button-comment" value="verstuur">
                    </div>
                    <input type="hidden" name="action" value="add-comment">
                    <input type="hidden" name="id_video" value="<?php echo $_GET['id'] ?>">
                    <input type="hidden" name="id_account" value="<?php echo $videoOwner['id'] ?>">
                    <input type="hidden" name="username" value="<?php if(isset($_SESSION['user'])){echo $_SESSION['user']['username'];}else {echo 'gast';}?>">
                </form>
                <div class=ranglist-persons>
                    <ul class="ranglist-comments">
                        <?php if($comments!== false):?>
                        <?php foreach($comments as $comment):?>
                            <li class="ranglist-comment"><span class="subtitle"><?php echo $comment['username']?>: </span><?php echo $comment['comment']?></li>
                        <?php endforeach;?>
                        <?php endif;?>
                    </ul>
                </div>
            </section>
        </aside>
    <?php endif;?>
</div> 
<script src="js/validate.js"></script>