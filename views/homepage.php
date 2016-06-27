<?php use \Epoque\jQueryUI\Tabs; ?>

<div class="row">
    <div class="col-md-6">
      
        <section>
            <h2>Les Actualités</h2>
            <?php
            print new Tabs([
                'id' => 'news-tabs',
                'class' => 'tabs',
                'tabs' => [
                    'econ-news' => 'Economy',
                    'biz-news' => 'Business',
                    'top-news' => 'Top Stories',
                    'world-news' => 'World']
                ]);
            ?>
            <script src="<?php echo JS_DIR.'news.js'; ?>"></script>
        </section>

    </div>

    <div class="col-md-3 col-md-offset-1">
        <section>
            <h2>Les Signets</h2>
        </section>
    </div>
</div>
