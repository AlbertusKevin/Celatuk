<body>
    <div class="container">
        <?php
        $members = $data['members'];
        $user = $data['member'];
        ?>

        <h1 class="coloringblack">Group Members</h1>
        <table cellpadding="10">
            <?php foreach ($members as $member) : ?>
                <?php if ($member['role'] == 'admin') : ?>
                    <tr>
                        <td>
                            <img src="<?= URL ?>/assets/img/user/<?= $member['username'] ?>/profile/<?= $member['picture'] ?>" alt="<?= $member['username'] ?>" class="pp">
                        </td>
                        <td>
                            <?= $member['name']; ?>
                        </td>
                        <?php if ($data['username'] == $member['username']) : ?>
                            <td colspan="2">
                                <?= $member['role']; ?>
                            </td>
                        <?php else : ?>
                            <td>
                                <?= $member['role']; ?>
                            </td>
                            <?php if ($user) :
                                if ($user['role'] == 'admin') : ?>
                                    <?php if ($member['role'] == 'admin') : ?>
                                        <td>
                                            <a href="<?= URL ?>/group/demote/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>" class="coloring">demote</a> |
                                            <a href="<?= URL ?>/group/kick/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>" class="coloring">kick</a>
                                        </td>
                                    <?php elseif ($member['role'] == 'moderator') : ?>
                                        <a href="<?= URL ?>/group/promote/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>" class="coloring">promote</a> |
                                        <a href="<?= URL ?>/group/demote/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>" class="coloring">demote</a> |
                                        <a href="<?= URL ?>/group/kick/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>" class="coloring">kick</a>
                                    <?php else : ?>
                                        <a href="<?= URL ?>/group/promote/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>" class="coloring">promote</a>
                                        <a href="<?= URL ?>/group/kick/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>" class="coloring">kick</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    </tr>
                <?php endforeach; ?>

                <?php foreach ($members as $member) : ?>
                    <?php if ($member['role'] != 'admin' && $member['status'] != 0) : ?>
                        <tr>
                            <td>
                                <img src="<?= URL ?>/assets/img/user/<?= $member['username'] ?>/profile/<?= $member['picture'] ?>" alt="<?= $member['username'] ?>" width="150">
                            </td>
                            <td>
                                <?= $member['name']; ?>
                            </td>
                            <td>
                                <?= $member['role']; ?>
                            </td>
                            <?php if ($user['role'] == 'admin') : ?>
                                <td>
                                    <?php if ($member['role'] == 'moderator') : ?>
                                        <a href="<?= URL ?>/group/demote/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>">demote</a> |
                                    <?php endif; ?>
                                    <a href="<?= URL ?>/group/promote/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>">promote</a> | <a href="<?= URL ?>/group/kick/<?= $data['groupname']; ?>/<?= $data['username']; ?>/<?= $member['username']; ?>">kick</a>
                                </td>

                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
        </table>
    </div>