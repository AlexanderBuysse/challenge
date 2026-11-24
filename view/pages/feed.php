<div class="feed">
    <section class="feed__section-one">
        <div class="section-one__header">
            <div>
                <h2 class="red-word"><?= $attempt ? escape($attempt['username']) : 'Alle pogingen' ?></h2>
                <p class="feed-text">Voorbeeldpogingen met fictieve deelnemers, tijden, likes en reacties.</p>
            </div>
            <button type="button" class="button-upload" data-demo-action>Nieuwe poging</button>
        </div>
        <div class="middle feed-videos">
            <?php if ($attempt): ?>
                <p class="feed-text">Tijd: <?= $attempt['time'] ?> seconden</p>
                <?php if (isset($attempt['video'])): ?>
                    <video width="1000" height="600" controls preload="metadata">
                        <source src="<?= escape($attempt['video']) ?>" type="video/mp4">
                    </video>
                <?php else: ?>
                    <p class="feed-text">Bekijk de <a href="index.php?page=feed&amp;choice=video&amp;id=4">voorbeeldvideo</a>.</p>
                <?php endif; ?>
                <a class="button-like" href="index.php?page=feed&amp;choice=all">Alle pogingen</a>
            <?php else: ?>
                <?php if ($choice === 'video'): ?>
                    <p class="feed-text">Deze voorbeeldpoging bestaat niet.</p>
                <?php endif; ?>
                <div class="feed-infobar">
                    <p class="feed-text"><?= count($attempts) ?> pogingen</p>
                    <form action="index.php" method="get">
                        <input type="hidden" name="page" value="feed">
                        <label>Sorteer op
                            <select name="sort">
                                <option value="id" <?= $sort === 'id' ? 'selected' : '' ?>>recent</option>
                                <option value="time" <?= $sort === 'time' ? 'selected' : '' ?>>snelst</option>
                                <option value="popular" <?= $sort === 'popular' ? 'selected' : '' ?>>populairst</option>
                            </select>
                        </label>
                        <button type="submit" class="button-like">Sorteer</button>
                    </form>
                </div>
                <div class="feed-cards">
                    <?php foreach ($attempts as $video): ?>
                        <article class="feed-card">
                            <h3 class="hidden"><?= escape($video['username']) ?></h3>
                            <a href="index.php?page=feed&amp;choice=video&amp;id=<?= $video['id'] ?>" class="video-play"
                               aria-label="Bekijk de poging van <?= escape($video['username']) ?>">
                                <img class="video-thumbnail" src="assets/img/board2.svg" alt="">
                                <p class="button-place">Plaats: <?= $places[$video['id']] + 1 ?></p>
                                <span class="video-placeholder" aria-hidden="true"><?= isset($video['video']) ? '▶' : '→' ?></span>
                            </a>
                            <div class="card-info">
                                <p>Tijd: <?= $video['time'] ?>s</p>
                                <button type="button" class="button-like" data-demo-action aria-label="<?= $video['likes'] ?> likes. Geef een like">
                                    <?= $video['likes'] ?> <img src="assets/img/kroon.svg" alt="" width="40" height="20">
                                </button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <aside class="aside">
        <section class="aside__ranglist">
            <?php if ($attempt): ?>
                <h2 class="aside__title">Tips</h2>
                <button type="button" class="button-like" data-demo-action>Geef een tip</button>
                <div class="ranglist-persons">
                    <ul class="ranglist-comments">
                        <?php foreach ($attempt['tips'] as $tip): ?>
                            <li class="ranglist-comment"><span class="subtitle"><?= escape($tip['username']) ?>:</span> <?= escape($tip['text']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <h2 class="aside__title">Ranglijst</h2>
                <div class="ranglist-persons">
                    <div class="ranglist-person">
                        <?php foreach ($ranking as $place => $rank): ?>
                            <div class="ranglist-all">
                                <div>
                                    <p class="ranglist__text-time"><?= $rank['time'] ?> seconden</p>
                                    <h3 class="ranglist__text-name"><?= escape($rank['username']) ?></h3>
                                </div>
                                <p><?= $place + 1 ?></p>
                            </div>
                            <svg class="title-line" width="360" height="15" viewBox="0 0 690 9" aria-hidden="true">
                                <line x2="681" transform="translate(4.5 4.5)" stroke="#a23740" stroke-linecap="round" stroke-width="10"/>
                            </svg>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </aside>
</div>
