<?php
//$comments = new \Core\Comments;
//$tag = new \Models\Tag;
    $access = new \Core\Access;
?>
<div class="container">
    <div class="content-block">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <div class="full-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="static_full_story">
                                <?php  
                                /*<h1 class="main_section__title"><?= $static_page['title'] ?></h1>*/
                                ?>
                                <?= $article['full_story'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
/*
<div class="content-block">
    <div class="row">
        <div class="col-md-8">
            <div class="full-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="full_story article_body">
                            <?= $bread_crumbs ?>	
                            <div class="head-news">
                                <div class="head-news-info">
                                    <span>Просмотры: <?= $article['views'] ?></span>
                                    <span>Комментариев: <?= $article['count_comments'] ?></span>
                                    <span>Дата: <?= date('d.m.Y', $article['date']) ?></span>
                                    <span>Тема: <?= $article['title_category'] ?></span>
                                </div>
                            </div>
                            <h1><?= $article['title'] ?></h1>
                            <div class="text-news">
                                <?= $article['full_story'] ?>
                            </div>
                            <div class="tags-block">
                                <?php
                                $arr_tags = $tag->getAllTagsArticle($article['id']);
                                if (is_array($arr_tags)) {
                                    foreach ($arr_tags as $tag) {
                                        echo '<a href="/tag/show-post?name=' . $tag['tag'] . '" class="tag">' . $tag['tag'] . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?= $comments->getArticleComments($article['id']) ?>
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
*/
 ?>


<?php if ($access->allowGroup(['admin'])): /* только для админа, дополнительные возможности */ ?>
    <script>
        var _option_array = {
            'type':'article',
            'id':<?=$article['id']?>,
        }
    </script>
<?php endif ?>






