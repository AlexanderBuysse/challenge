<div class="container-form">
    <article class="article-form">
            <h2 class="form-title">help het koningspaar</h2>
            <svg class="title-line" width="530" height="9" viewBox="0 0 690 9">
                <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="9"/>
            </svg>            
            <p class="form-text">Word een helper van het koningspaar en wordt zo nog beter waardoor de kans groter is dat je in de hall of fame terecht komt.</p>
            <div class="form-buttons">
                <a href="index.php?page=login&choice=login" class="button-form <?php if(isset($_GET['choice']))if($_GET['choice']==='login') echo 'selected'?>">login</a>
                <a href="index.php?page=login&choice=register" class="button-form <?php if(isset($_GET['choice']))if($_GET['choice']!=='login') echo 'selected'?>">registreer</a>
            </div>
            <?php if(isset($_GET['choice']))if($_GET['choice']!=='login'):?>
            <form action="index.php?page=login&choice=register" method="POST" class="form form-register middle">
                <div>
                    <input type="hidden" name="action" value="register">
                    <div class="form-input">
                        <p class="error"><?php if(!empty($errors['username'])) echo $errors['username'];?></p>
                        <label> gebruikersnaam  <br>
                            <input class="input-field input" placeholder="hendrick" type="text" name="username" maxlength="15" minlength="3" required>
                        </label>
                    </div>
                    <div class="form-input">
                        <p class="error"><?php if(!empty($errors['password'])) echo $errors['password'];?></p>
                        <label> wachtwoord <br>
                            <input  class="input-field input" placeholder="•••••••" type="password" name="password" maxlength="18" minlength="3" required>
                        </label>
                    </div>
                    <div class="form-input">
                        <p class="error"><?php if(!empty($errors['password'])) echo $errors['confirm_password'];?></p>
                        <label>herhaal wachtwoord <br>
                            <input  class="input-field input" type="password" placeholder="•••••••" name="confirm_password" maxlength="18" minlength="3" required>
                        </label>
                    </div>
                </div>
                <input type="submit" class="register-button form-submit longer-width" value="bevestig">
            </form>
            <?php elseif(isset($_GET['choice'])):?>
            <form action="index.php?page=login&choice=login" method="POST" class="form form-login middle">
                <div>
                    <input type="hidden" name="action" value="login">
                    <div class="form-input">
                        <p class="error"><?php if(!empty($errors['username'])) echo $errors['username'];?></p>
                        <label> gebruikersnaam <br>
                            <input class="input-field input" placeholder="hendrick" type="text" name="username" maxlength="15" minlength="3" required>
                        </label>
                    </div>
                    <div class="form-input">
                        <p class="error"><?php if(!empty($errors['password'])) echo $errors['password'];?></p>
                        <label> wachtwoord <br>
                            <input  class="input-field input" placeholder="•••••••" type="password" name="password" maxlength="18" minlength="3" required>
                        </label>
                    </div>
                </div>
                <input type="submit" class="register-button form-submit longer-width" value="bevestig">
            </form>
            <?php endif;?>
    </article>
    <img class="form-img" src="assets/img/login.svg" alt="login afbeelding">  
</div>
<script src="js/validate.js"></script>