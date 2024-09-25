<?php
$session = new \Core\Session;
$user_model = new \Models\User;
$access = new \Core\Access;

$user_login = $session->getUserLogin();
$user_array = $user_model->getUser('login', $user_login);
?> 

    <?php if ($access->userAuth()): ?>    
       <li class="nav-item">
           <?php
           $session = new \Core\Session;
           $user = new \Models\User();
           $user = $user->getUserById($session->getUserId());

           $user_login = $session->getUserLogin();
           if ($user_login === 'admin') {
            $user_degree = 'Администратор';
           }
           ?>
           <a class="nav-link name-class" href="#"><?= $user['name'].' '.$user['surname'] ?> <span class="badge text-bg-info">
<?= $user_degree ?></span>  </a>

       </li>
        <li class="nav-item">
            <a  href="/auth/logout" class="btn btn-danger">Выйти</a>
        </li>
    <?php else: ?>   


    <?php endif; ?>
