<?php $post = $data['post']; ?>

<body>
    <h4><?= Message::picture406(); ?></h4>
    <h4><?= Message::emptyField404(); ?></h4>
    <form action="<?= URL ?>/group/edit_process/<?= $data['groupname'] ?>/<?= $post['id']; ?>/<?= $data['username'] ?>" method="post" enctype="multipart/form-data">
        <div class="container">
            <textarea name="text" cols="100" rows="7"><?= $post['content']; ?> </textarea>
            <select name="privacy">
                <option value="group">Group</option>
            </select><br>
            <?php if ($post['image'] != " ") : ?>
                <img src="<?= URL; ?>/assets/img/user/<?= $post['username'] ?>/post/<?= $post['image'] ?>" width="150">
            <?php endif; ?>
            <input type="file" name="img">
            <button type="submit">Edit</button>
        </div>
    </form>