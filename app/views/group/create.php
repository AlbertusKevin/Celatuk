<body>
    <!-- Pesan jika ada error, dari class Message dengan method static -->
    <h4><?= Message::picture406(); ?></h4>
    <h4><?= Message::picture404(); ?></h4>
    <h4><?= Message::uniqueGroupname406(); ?></h4>
    <!-- Content -->
    <form action="<?= URL; ?>/group/store/<?= $data['username']; ?>" method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="logo"><img class="svg" src="<?= URL ?>/assets//images/logo.svg"></div>

            <input type="hidden" name="founder" value="<?= $data['username']; ?>">

            <div class="label">Group Name</div>
            <input type="text" placeholder="Enter Name for Your Group" name="groupName" required>

            <div class="label">About</div>
            <textarea name="about" rows="7" cols="50" style="margin-top: 5px;" style="margin-top: 5px;">Input short info about your group</textarea>

            <div class="label">Visibility</div>
            <select name="visibility" style="margin-top: 5px;" style="margin-top: 5px;">
                <option value="private" onclick="alert('Private: Member must send a request to join');">
                    Private
                </option>
                <option value="public" onclick="alert('Public: Member does not need to send a request to join');">
                    Public
                </option>
            </select>

            <div class="label" style="margin-top: 5px;">Profile Picture</div>
            <input type="file" id="picture" name="picture" required>

            <div class="label">Background Picture</div>
            <input type="file" id="bg_picture" name="bg_picture" required>

            <button type="submit"><b>Create</b></button>
        </div>
    </form>