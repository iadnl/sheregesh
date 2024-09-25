<?php
// SITE PAGINATION
    $get = new \Core\Get;
    $link='?';
    foreach ($get->getArray() as $key => $value) {
        if ($key<>'page') {
            $link.=$key.'='.$value.'&';
        }
    }
?>
<?php if ($count_paginat > 1): ?>  
<div class="pagination-block">
    <nav aria-label="Page navigation example">
  <ul class="pagination justify-content-center">
    <li class="page-item">
    <?php if ($page_num !== 1): ?>
      <a class="page-link" href="<?=$link?>page=1" aria-label="Previous">
          <span aria-hidden="true"><i class="glyphicon glyphicon-chevron-left"></i> Первая</span>
      </a>
    <?php endif ?>

    </li>
    <?php 
    $count_right_left_num = 10; // Количество номеров справа и слево

    if (($page_num-$count_right_left_num) > 0) { // левая сторона
      $i = $page_num - $count_right_left_num;
    } else {
      $i = 1;
    }
    for ($i; $i < $page_num ; $i++) { 
        echo '<li class="page-item"><a class="page-link" href="'.$link.'page='.$i.'">'.$i.'</a></li>';  
    }
    
    if (($page_num+$count_right_left_num) < $count_paginat) { // правая сторона
      $j = $page_num + $count_right_left_num;
    } else {
      $j = $count_paginat;
    }
    for ($i=$page_num; $i < $j+1 ; $i++) {   
      if ($i == $page_num) {
        echo '<li class="page-item active"><a class="page-link" href="#">'.$page_num.'</a></li>';
      } else {
        echo '<li class="page-item"><a class="page-link" href="'.$link.'page='.$i.'">'.$i.'</a></li>';  
      }
    }

    ?>
    <li class="page-item">
    <?php if ($count_paginat != $page_num): ?>
      <a class="page-link" href="<?=$link?>page=<?=$count_paginat?>" aria-label="Next">
          <span aria-hidden="true">Последняя <i class="glyphicon glyphicon-chevron-right"></i></span>
      </a>
    <?php endif ?>
    </li>
  </ul>
        </nav>
</div>
<?php endif ?>