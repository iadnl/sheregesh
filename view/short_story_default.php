<?php
$tag = new \Models\Tag;
?>
<?php foreach ($pages_array as $value): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="short_news_block">
                <h4 class="short_news_block_title"><a href="<?= $value['alt_name'] ?>"><?= $value['title'] ?></a></h4>
                <div class="short_news_block_content">
                    <div class="short_news_block_text">
                        <?= $value['short_story'] ?> 
                    </div>
                    <div class="clearfix"></div>
                    <div class="tags-block-short-news">
                        <?php
                        if (isset($value['id'])) {
                            $arr_tags = $tag->getAllTagsArticle($value['id']);
                            if (is_array($arr_tags)) {
                                foreach ($arr_tags as $tag_val) {
                                    echo '<a href="/tag/show-post?name=' . $tag_val['tag'] . '" class="tag">' . $tag_val['tag'] . '</a>';
                                }
                            }
                        }
                        ?>
                    </div>
                    <div class="short_news_block_option">
                        <span>Просмотров: <?= $value['views'] ?></span>
                        <span><a href="<?= $value['alt_name'] ?>">Комментариев: <?= $value['count_comments'] ?></a></span>
                        <span style="float: right;">Дата: <?= date("d.m.Y", $value['date']) ?></span>
                    </div>
                </div>
            </div>
        </div>       
    </div>
<?php endforeach ?>
