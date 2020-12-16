<?php  $friend = $data['friendlist']; ?>
<body>
    <div class="container">
    <h1 class="coloringblack ppmargin">User List</h1>
    <table>
        <!-- Jika belum ada user yang terdaftar -->
        <?php if(empty($data['user'])): ?>
            <tr>
                <td>Belum ada user yang terdaftar</td>
            </tr>
        <?php else:

            //Jika sudah ada user, akan ditampilkan dengan beberapa pengkondisian
            foreach($data['user'] as $user):
                $i = 0;
                $found = false;
                // var_dump($user['username'] == $friend[$i]['username'] || $user['username'] == $friend[$i]['friendUserName']);die;s
                while(!$found && $i < count($friend)):
                    //untuk kasus user tersebut sudah mengirim request // sudah request, tapi belum ada response
                    if($user['username'] == $friend[$i]['username'] || $user['username'] == $friend[$i]['friendUserName']): ?>
                                <tr>
                                    <td>
                                        <img src="<?=URL;?>/assets/img/user/<?=$user['username'];?>/profile/<?=$user['picture'];?>" alt="<?=$user['username'];?> profile picture" class="pp ppmargin">
                                    </td>
                                    <td>
                                        <div class="ppmargin">
                                            <?= $user['name']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ppmargin">
                                            <?=$user['username'];?>
                                        </div>
                                    </td>
                                    <td><a href = "<?=URL?>/user/profile/<?=$data['username'];?>/<?= $user['username']; ?>"><div class="ppmargin coloring">Detail | </div></a></td>
                                    <td>
                        <?php if($friend[$i]['status'] == 0): ?>
                            <?php if($user['username'] == $friend[$i]['friendUserName']): ?>
                                        <a href="<?=URL?>/friend/abort/<?=$data['username']?>/<?=$user['username']?>"><div class="ppmargin coloring">Abort</div></a>
                            <?php else: ?>
                                        <br>
                                        <a href="<?=URL?>/friend/accept/<?=$data['username']?>/<?=$user['username']?>" class="ppmargin" style="color:green;">Accept</a> 
                                        <a href="<?=URL?>/friend/reject/<?=$data['username']?>/<?=$user['username']?>" class="ppmargin" style="color:red">Reject</a> 
                            <?php endif; ?>
                        <?php else: ?>
                                        <div class="ppmargin" style="color:purple;">Sudah Berteman</div>
                        <?php endif;?>
                                    </td>
                                </tr>
                        <?php $found = true;
                    endif;
                    $i++;
                endwhile;
                
                if(!$found): ?>
                            <tr>
                                <td>
                                    <img src="<?=URL;?>/assets/img/user/<?=$user['username'];?>/profile/<?=$user['picture'];?>" alt="<?=$user['username'];?> profile picture" class="pp ppmargin">
                                </td>
                                <td>
                                    <div class="ppmargin">
                                        <?= $user['name']; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="ppmargin">
                                        <?=$user['username'];?>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?=URL?>/friend/add/<?=$data['username']?>/<?=$user['username']?>"><div class="ppmargin coloring">Add</div></a>
                                </td>
                            </tr>
                <?php endif;
            endforeach;
        endif; ?>
    </table>
    </div>