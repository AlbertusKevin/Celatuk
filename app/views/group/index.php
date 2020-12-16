<body>
<div class="container">
    <h4><?= Message::createGroup200(); ?></h4>
    <?php if(isset($_SESSION['groupname'])):?>
    <h4><?= Message::deleteGroup204($_SESSION['groupname']) ?></h4>
    <h4><?= Message::memberLeave204($_SESSION['groupname'],$data['username']); ?></h4>
    <?php endif; ?>
    <h1 class="coloringblack ppmargin">Group</h1>
    <a href="<?=URL?>/group/create/<?=$data['username']?>" class="ppmargin coloring">Buat Group </a>
    <table cellpadding = "10">
        <?php if(count($data['group']) == 0): ?>
            <tr>
                <td colspan = "3">
                    <h4>Belum ada grup yang dibuat pada aplikasi ini</h4>
                </td>
            </tr>
        <?php endif; ?>
        <?php foreach($data['group'] as $group): ?>
            <tr>
                <td>
                    <a href="<?=URL?>/group/homepage/<?=$group['groupName'].'/'.$data['username'];?>">
                    <img 
                        src="<?=URL?>/assets/img/group/<?=$group['groupName']?>/profile/<?=$group['picture']?>" 
                        alt="<?=$group['groupName']?> Picture"
                        class="pp ppmargin">
                </a>
                </td>
                <td>
                    <div class="ppmargin">
                        <?= $group['groupName'];?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>