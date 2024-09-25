<div class="content-block">
    <div class="row">
        <div class="col-md-8">
            <div class="full-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="full_story">
                            <?= $bread_crumbs_custom ?>
                            <?= $articles_short_story ?>
                        </div>
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