<div class="feed">
    <section class="feed__section-one">
        <div class="section-one__header">
            <div>
                <h2 class="red-word"><?= $attempt ? escape($attempt['username']) : 'All entries' ?></h2>
                <p class="feed-text">Demo entries with fictional bakers, times, likes and comments.</p>
            </div>
            <button type="button" class="button-upload" data-demo-action>New entry</button>
        </div>
        <div class="middle feed-videos">
            <?php if ($attempt): ?>
                <p class="feed-text">Time: <?= $attempt['time'] ?> seconds</p>
                <?php if (isset($attempt['video'])): ?>
                    <video width="1000" height="600" controls preload="metadata">
                        <source src="<?= escape($attempt['video']) ?>" type="video/mp4">
                    </video>
                <?php else: ?>
                    <p class="feed-text">Watch the <a href="index.php?page=feed&amp;choice=video&amp;id=4">sample video</a>.</p>
                <?php endif; ?>
                <a class="button-like" href="index.php?page=feed&amp;choice=all">All entries</a>
            <?php else: ?>
                <?php if ($choice === 'video'): ?>
                    <p class="feed-text">This demo entry could not be found.</p>
                <?php endif; ?>
                <div class="feed-infobar">
                    <p class="feed-text"><?= count($attempts) ?> entries</p>
                    <form action="index.php" method="get">
                        <input type="hidden" name="page" value="feed">
                        <label>Sort by
                            <select name="sort">
                                <option value="id" <?= $sort === 'id' ? 'selected' : '' ?>>Most recent</option>
                                <option value="time" <?= $sort === 'time' ? 'selected' : '' ?>>Fastest</option>
                                <option value="popular" <?= $sort === 'popular' ? 'selected' : '' ?>>Most popular</option>
                            </select>
                        </label>
                        <button type="submit" class="button-like">Sort</button>
                    </form>
                </div>
                <div class="feed-cards">
                    <?php foreach ($attempts as $video): ?>
                        <article class="feed-card">
                            <h3 class="hidden"><?= escape($video['username']) ?></h3>
                            <a href="index.php?page=feed&amp;choice=video&amp;id=<?= $video['id'] ?>" class="video-play"
                               aria-label="View the entry by <?= escape($video['username']) ?>">
                                <img class="video-thumbnail" src="assets/img/moelleuxafbeelding.svg" alt="">
                                <p class="button-place">Rank: <?= $places[$video['id']] + 1 ?></p>
                                <span class="video-placeholder" aria-hidden="true"><?= isset($video['video']) ? '▶' : '→' ?></span>
                            </a>
                            <div class="card-info">
                                <p>Time: <?= $video['time'] ?>s</p>
                                <button type="button" class="button-like" data-demo-action aria-label="<?= $video['likes'] ?> likes. Give a like">
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
                <button type="button" class="button-like" data-demo-action>Leave a tip</button>
                <div class="ranglist-persons">
                    <ul class="ranglist-comments">
                        <?php foreach ($attempt['tips'] as $tip): ?>
                            <li class="ranglist-comment"><span class="subtitle"><?= escape($tip['username']) ?>:</span> <?= escape($tip['text']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <h2 class="aside__title">Leaderboard</h2>
                <div class="ranglist-persons">
                    <div class="ranglist-person">
                        <?php foreach ($ranking as $place => $rank): ?>
                            <div class="ranglist-all">
                                <div>
                                    <p class="ranglist__text-time"><?= $rank['time'] ?> seconds</p>
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
