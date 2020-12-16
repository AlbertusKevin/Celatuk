<?php ?>
<div class="container">
    <h1><?= $data['groupname']; ?></h1>
    <?php
    if(empty($data['post'])): ?>
        <h4>Belum ada Postingan</h4>
    <?php endif; ?>


    <?php foreach($data['post'] as $post): ?>
        <div class="post">
            <span><img src="<?=URL;?>/assets/img/user/<?=$post['username']?>/profile/<?=$post['picture']?>" width = "50"></span>
            <span><?=$post['username']?></span><br>

            <?php if($post['image'] != " "): ?>
                <img src="<?=URL;?>/assets/img/user/<?=$post['username'];?>/post/<?=$post['image']?>" alt="Can't load image!" width = "200px">
            <?php endif; ?>
            <span><?=$post['content']; ?></span><br>
            <?= $post['privacy']; ?>
        </div>
        <a href="<?=URL?>/group/accept_post/<?=$data['groupname'];?>/<?= $post['id']; ?>/<?=$data['username']?>">Verify</a> |
        <a href="<?=URL?>/group/reject_post/<?=$data['groupname'];?>/<?= $post['id']; ?>/<?=$data['username']?>">Reject</a>
<?php endforeach; ?>
</div>