<body>
    <div class="container">
        <?php $members = $data['members']; ?>
            <h1>Pending Member</h1>
            <table cellpadding = "10">
                <?php if(count($members) == 0): ?>
                <tr>
                    <td>Tidak ada permintaan untuk bergabung</td>
                </tr>
                <?php endif; ?>
                
                <?php foreach($members as $member): ?>
                <tr>
                    <td><img src="<?=URL?>/assets/img/user/<?=$member['username']?>/profile/<?=$member['picture']?>" alt = "<?=$member['username']?>" width = "150"></td>
                    <td><?= $member['name'] ?></td>
                    <td> <a href="<?=URL?>/group/request_accept/<?=$data['group'];?>/<?=$member['username']?>/<?=$data['username'];?>">terima</a> | <a href="<?=URL?>/group/request_reject/<?=$data['group'];?>/<?=$member['username']?>/<?=$data['username'];?>">tolak</a> </td>
                </tr>
                <?php endforeach; ?>
            </table>
    </div>