<body>
    <form action="<?=URL?>/group/store_post/<?= $data['groupname']; ?>/<?=$data['username']; ?>" method = "post" enctype = "multipart/form-data">
        <div class="container">
            <textarea name="text" cols="100" rows="7">What do you want to post?</textarea>
            <select name="privacy">
                <option value="group">Group</option>
            </select>
            <input type="file" name = "img">
            <button type = "submit">Post</button>
        </div>
    </form>
</body>