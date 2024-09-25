<?php
    $access = new \Core\Access;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="static-fullstory__title"><?= $static_page['title'] ?></h1>
            <div class="static-fullstory">                
                <?= $static_page['full_story'] ?>
            </div>
        </div>
    </div>
</div>
<?php if ($access->allowGroup(['admin'])): /* только для админа, дополнительные возможности */ ?>
    <script>
        var _option_array = {
            'type': 'static',
            'id':<?= $static_page['id'] ?>,
        }
    </script>
<?php endif; ?>
