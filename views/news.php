<?php use Epoque\Chameleon\Daemon; ?>
<?php use Epoque\jQueryUI\Tabs; ?>
<?php use Epoque\GitHub\Repos; ?>

<div class="row mainRow">
    
    <section class="col-md-8 col-md-offset-1 col-lg-offset-2">
        <header>
            <h2>Les Actualités</h2>
            <p>The Latest News</p>
        </header>

        <?php Daemon::contents(PHP_DIR.'mainMenuDropdown.php'); ?>
        
        <?php
        print new Tabs([
            'id' => 'news-tabs',
            'class' => 'tabs',
            'tabs' => [
                'biz-news' => 'Business',
                'top-news' => 'Top Stories',
                'world-news' => 'World']
            ]);
        ?>
        <script src="<?php echo JS_DIR.'news.js'; ?>"></script>
    </section>

</div>
