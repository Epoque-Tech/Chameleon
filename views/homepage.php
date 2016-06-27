<div class="row">
    <div class="col-md-6">
        <section>
            <h2>Les Actualités</h2>
            <div id="news-tabs">
                <ul>
                  <li><a href="#econ-news">Economy</a></li>
                  <li><a href="#biz-news">Business</a></li>
                  <li><a href="#top-news">Top Stories</a></li>
                  <li><a href="#world-news">World</a></li>
                </ul>
                <div id="econ-news" class="news"></div>
                <div id="biz-news" class="news"></div>
                <div id="top-news" class="news"></div>
                <div id="world-news" class="news"></div>
            </div>

            <script src="<?php echo JS_DIR.'news.js'; ?>"></script>
        </section>
      
      <?php
      $url = 'https://www.quandl.com/api/v1/datasets/LBMA/GOLD.json?rows=1';
      print_r(json_decode(file_get_contents($url))->data[0][1]); ?>
    </div>
    <div class="col-md-3 col-md-offset-1">
        <section>
            <h2>Les Signets</h2>
        </section>
    </div>
</div>
