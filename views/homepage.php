<?php use Epoque\jQueryUI\Tabs; ?>
<?php use Epoque\GitHub\Repos; ?>


<div class="row">
    <div class="col-md-6">
      
        <section>
            <h2>Les Actualités</h2>
            <?php
            print new Tabs([
                'id' => 'news-tabs',
                'class' => 'tabs',
                'tabs' => [
                    'biz-news' => 'Business',
                    'top-news' => 'Top Stories',
                    'world-news' => 'World',
                    'econ-news' => 'Economy']
                ]);
            ?>
            <script src="<?php echo JS_DIR.'news.js'; ?>"></script>
        </section>

        <br>
        
        <section id="github">
            <script src="<?php echo JS_DIR.'github.js'; ?>"></script>
        </section>
        <?php //print_r(Repos::enumerate()); ?>
    </div>

    <div class="col-md-3 col-md-offset-1">
        <section>
            <h2>Les Signets</h2>
        </section>
    </div>
</div>
