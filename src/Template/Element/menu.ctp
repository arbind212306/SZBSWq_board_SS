<?php
$session = $this->request->session();
$session_data = $session->read();
$user_type = $session_data["Auth"]["User"]["user_type"];
$access_menu = [];
if (empty($active)) {
    $active = 0;
}
if (!empty($session_data['Auth']['User']['access'])) {
    foreach ($session_data['Auth']['User']['access'] as $ac) {
        if (!empty($ac)) {
            $access_menu[] = $ac['id'];
        }
    }
}
if ($user_type == 1 || $user_type == 2 || $user_type == 3) {
    ?>


    <?php
    $top_cls = "";
    if (in_array($active, [1, 2, 3])) {
        $top_cls = "active";
    }
    
    if(in_array(13,$access_menu)&& in_array(14,$access_menu)) {
        ?>
    <li class="dropdown <?= $top_cls; ?>" >
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span>Onboarding <i class="fa fa-caret-down"></i></span>
        </a>
        <ul class="dropdown-menu">

            <?php
            $acalass = "";
            if ($active == 1) {
                $acalass = 'active';
            }
            ?>
            <li id ="1" class="<?= $acalass ?>"><?php if (in_array(13, $access_menu)) echo $this->Html->link('Manage Joinee', ['controller' => 'Users', 'action' => 'manageUser']); ?></li>

            <li role="separator" class="divider"></li>
            <?php
            $acalassl = "";
            if ($active == 2) {
                $acalassl = 'active';
            }
            ?>
            <li id ="2" class="<?= $acalassl; ?>"><?php if (in_array(14, $access_menu)) echo $this->Html->link('Joinee Logistics', ['controller' => 'Users', 'action' => 'logistics']); ?></li>
            <li role="separator" class="divider"></li>
            <?php
            $aclass = "";
            if ($active == 3) {
                $aclass = 'active';
            }
            ?>
    <!-- <li id="3" class="<?= $aclass ?>"><?php if (in_array(15, $access_menu)) //echo $this->Html->link('Confirmation',['controller' => 'Users', 'action' => 'confirmation']);               ?></li>
            -->                </ul>
    </li>

    <?php
    }
    $top_cls = "";
    if ($active == 4) {
        $top_cls = "active";
    }

    if (in_array(16, $access_menu)) {
        echo '<li class="dropdown ' . $top_cls . '">';
        echo $this->Html->link('<span>Roadmap</span>', ['controller' => 'Users', 'action' => 'roadmap'], ['escape' => false]);
        echo '</li>';
    }
    ?>
    <?php
    $top_cls = "";
    if ($active == 5) {
        $top_cls = "active";
    }
    if (in_array(17, $access_menu)) {
        echo '<li class="dropdown  ' . $top_cls . '">';
        echo $this->Html->link('<span>Feedback</span>', ['controller' => 'feedback', 'action' => 'index'], ['escape' => false]);
        echo '</li>';
    }
    ?>
    <?php
    $top_cls = "";
    if (in_array($active, [6, 7, 8])) {
        $top_cls = "active";
    }
    
    if(in_array(18,$access_menu)&& in_array(19,$access_menu)&& in_array(20,$access_menu)) {
        ?>

        <li class="dropdown <?= $top_cls; ?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span>Administration <i class="fa fa-caret-down"></i></span>
            </a>
            <?php if ($user_type == 1 || $user_type == 3) { ?>
                <ul class="dropdown-menu">

                    <?php
                    $aclass = "";
                    if ($active == 6) {
                        $aclass = 'active';
                    }
                    ?>       
                    <li id="6" class=" <?= $aclass ?>"><?php if (in_array(18, $access_menu)) echo $this->Html->link('Roles', ['controller' => 'Users', 'action' => 'manageRole']); ?></li>
                    <li role="separator" class="divider"></li>
                    <?php
                    $aclass = "";
                    if ($active == 7) {
                        $aclass = 'active';
                    }
                    ?> 
                    <li  id="7 "class="<?= $aclass ?>"><?php if (in_array(19, $access_menu)) echo $this->Html->link('Users', ['controller' => 'Users', 'action' => 'userManagement']); ?></li>
                    <li role="separator" class="divider"></li>
                    <?php
                    $aclass = "";
                    if ($active == '8') {
                        $aclass = 'active';
                    }
                    ?>
                    <li  id ="8" class="<?= $aclass ?>"><?php if (in_array(20, $access_menu)) echo $this->Html->link('Manage Logistics', ['controller' => 'Logistics', 'action' => 'index']); ?></li>

                </ul>
            <?php } ?>
        </li>


        <?php
    }
}
?>

