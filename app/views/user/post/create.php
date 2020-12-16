<body>

<form action="<?=URL?>/post/create/<?=$data['username']?>" method = "post" enctype = "multipart/form-data">
    <textarea name="text" cols="100" rows="7">What do you want to post?</textarea>
    <select name="privacy">
        <option value="private">Private</option>
        <option value="public">Public</option>
        <option value="friend">Friend</option>
    </select><br>
    <input type="file" name = "img">
    <button type = "submit">Post</button>
</form>