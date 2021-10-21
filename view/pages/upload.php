<div class="middle">
<section class="upload">
    <h2 class="upload-title">upload je poging</h2>
    <svg class="title-line" width="700" height="9" viewBox="0 0 690 9">
        <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="9"/>
    </svg> 
    <div class="upload__section">
        <img class="upload__section-img" src="assets/img/upload.svg" alt="afbeelding princes koning koningin"> 
        <div>
            <div class="upload__login">
                    <?php if(!isset($_SESSION['user'])):?>
                    <p>ga verder als gast</p>
                    <p class="login-big">of</p>
                    <p>met een account</p>
                    <a href="index.php?page=login&choice=login" class="login-button login-big">maak een account of log in</a>
                <?php elseif(isset($_SESSION['user'])):?>
                    <p class="login-big">ingelogd als <?php echo $_SESSION['user']['username'];?></p>
                <?php endif;?>
            </div>
            <form action="index.php?page=upload" class="form-upload" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add-video">
                <input type="hidden" name="id_account" value="<?php if(isset($_SESSION['user'])){echo $_SESSION['user']['id']; }else{ echo 1;}?>">
                <input type="hidden" name="path_thumbnail" value="0">
                <div class="form__video-thumbnail">
                    <div class="video-inputs">
                        <p class="error"></p>
                        <div>
                        <input type="file" id="file" name="video" accept="image/png, image/jpeg, image/gif, video/mp4" required class="button-file">
                        <label for="file">Kies een video (mp4)</label><br>
                        </div>

                        <div>
                        <p class="error"></p>
                        <label class="video-input"><span class="login-big">tijd</span><br>
                            <input type="number" minlength="2" name="time" class="input-sec input" required>seconden
                        </label>
                        </div>
                    </div>
                    <div class="video">
                        <img src="assets/img/thumbnail.svg" alt="thumbnail">
                    </div>
                </div>
                <input type="submit" class="register-button form-submit margintop" value="voltooi je upload">
            </form>
        </div>
    </div>
</section>
</div>
<script src="js/validate.js"></script>