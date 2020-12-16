<?php $friends = $data['friend']; ?>
<body>

<div class="container">
    <h1 class="coloringblack">Requested Friend List</h1>
    <table>
    <?php if(empty($friends)): ?>
        <tr>
            <td>Belum ada permintaan pertemanan</td>
        </tr>
    <?php endif;?>

    <?php foreach($friends as $friend): ?>
        <tr>
            <td>
                <img src="<?=URL;?>/assets/img/user/<?=$friend['username'];?>/profile/<?=$friend['picture'];?>" alt="<?=$friend['username'];?> profile picture" class="pp ppmargin">
            </td>
            <td>
                <div class="ppmargin">
                    <?= $friend['name']; ?>
                </div>
            </td>
            <td>
                <div class="ppmargin">
                    <?=$friend['username'];?>
                </div>
            </td>
            <td>
                <div class="ppmargin">
                    <a href="<?=URL?>/friend/accept/<?=$data['username']?>/<?=$friend['username']?>" style="color:green;">Accept</a> | <a href="<?=URL?>/friend/reject/<?=$data['username']?>/<?=$friend['username']?>" style="color:red;">Reject</a> 
                </div>
            </td>
        </tr>
    <?php endforeach;?>
    </table>
</div>