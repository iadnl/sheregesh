<div class="container">
  <div class="row">
  <div class="col-md-9">
    <div class="user-search">
<form method="get">
  <div class="row">
    <div class="col-md-12">
      <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Логин или имя пользователя " value="<?=$query?>">
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit">Поиск</button>
          </span>
          <div class="input-group-option">Искать по: 
          <input type="radio" <?=$type!=='name'?'checked':''?> name="type" value="login"> логину
          <input type="radio" <?=$type==='name'?'checked':''?> name="type" value="name"> имени</div>
      </div>
    </div>
  </div>
</form>
</div>

<div class="list-users">
<?php if (count($users_array) === 0): ?>
  <p>Пользователей не найдено.</p>
<?php endif ?>
  <?php foreach ($users_array as $key => $value): ?>
    <div class="media">
      <div class="media-left">
        <a href="/user/<?=$value['login']?>">
          <img class="media-object" src="
          <?php 
            if ($value['photo'] === 1)
              echo '/asset/img/userphoto/'.md5('min'.$value['login']).'.png';
            else 
              echo '/asset/img/template/mindefault.png';
          ?>
          " alt="">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading"><a href="/user/<?=$value['login']?>"><?=$value['login']?> (<?=$value['name']==''?'-':$value['name']?>)</a> 
        <?=$value['banned']==1?'<span>Пользователь заблокирован <i class="glyphicon glyphicon-lock"></i></span>':''?></h4>
        <div class="desc-info">
        <ul>
          <li>
            Дата регистрации: <?=date('Y-m-d', $value['reg_date'])?> <br> 
          </li>
          <li>
            Дата последнего посещения: <?=date('Y-m-d',$value['last_date'])?>
          </li>
        </ul>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>
      <?=$pagination?>
  </div>
</div>
</div>