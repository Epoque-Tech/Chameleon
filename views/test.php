<?php

use Epoque\Chameleon\HtmlSimpleContactForm as Form; ?>


<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-2">
        <?php
        print new Form([
            'id' => 'testForm',
            'legend' => 'Test Form'
        ]);
        ?>
    </div>
  </div>
</div>

<script src="<?php echo JS_DIR.'test.js'; ?>"></script>