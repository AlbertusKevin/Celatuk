<?php $post = $data['post']; ?>
<body>

<form action="<?=URL?>/post/edit/<?=$data['username']?>/<?=$post['id']; ?>" method = "post" enctype = "multipart/form-data">
    <textarea name="text" cols="100" rows="7"><?= $post['content'];?> </textarea>
    <select name="privacy">
        <option value="private" <?php if($post['privacy'] == 0){ ?> selected <?php } ?> >Private</option>
        <option value="public" <?php if($post['privacy'] == 1){ ?> selected <?php } ?> >Public</option>
        <option value="friend" <?php if($post['privacy'] == 2){ ?> selected <?php } ?> >Friend</option>
    </select><br>
    <?php if($post['image'] != " "):?>
    <img src="<?=URL;?>/assets/img/user/<?=$post['username']?>/post/<?=$post['image']?>" width = "150">
    <?php endif;?>
    <input type="file" name = "img">
    <button type = "submit">Edit</button>
</form>