<?php
$access = new \Core\Access;
?>
<div class="content-block">
    <div class="row">
        <div class="col-md-8">
            <div class="full-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="full_story">
                            <?= $bread_crumbs ?>
                            <h1 class="category-title">Категория: <?= $category['title'] ?></h1>
                            <div class="category-desc">
                                <?= $category['full_story'] ?>
                            </div>
                        </div>
                        <?= $news ?>
                        <?= isset($pagination) ? $pagination : '' ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-content-block">
            <div class="col-md-4">
                <div class="right-content">
                    <?= isset($sidebar_content) ? $sidebar_content : '' ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php if ($access->allowGroup(['admin'])): /* только для админа, дополнительные возможности */ ?>
    <script>
        var _option_array = {
            'type':'category',
            'id':<?=$category['id']?>,
        }
    </script>
<?php endif ?>

