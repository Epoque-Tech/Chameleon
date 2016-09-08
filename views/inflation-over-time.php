<?php use Epoque\Chameleon\Daemon; ?>
<?php Daemon::contents(PHP_DIR.'CPI.php'); ?>

<div class="row mainRow">
    <section class="col-md-8 col-md-offset-1 col-lg-offset-2">
        <header>
            <h2>Dollar Value Over Time</h2>
        </header>
        
        <?php Daemon::contents(PHP_DIR.'mainMenuDropdown.php'); ?>

        <ul class="nav nav-pills nav-stacked">
          <li role="presentation"><a href="/inflation">Back to Inflation Functions</a></li>
        </ul>
        
        <form id="dollarValueOverTime">
            <legend>The Dollar's Value Over Time</legend>
            <input type="number" placeholder="Dollar Value" min="1.00"><br>
            <select id="years"></select>
        </form>

    </section>
    <script>
    $.ajax({
        url: APP.requestURL,
        method: 'POST',
        data: {'years-indexed':true},
        success: function (data, textStatus, jqXHR) {
            var years = data.split(',');
            var yearOpts = '';
            
            years.forEach( function (e, i, a) {
                yearOpts += '<option>' + e + '</option>';
            });
            
            $('#years').html(yearOpts);
        }
    });
    
    $("#dollarValueOverTime").submit(function (event) {
        event.preventDefault();
    });
    </script>
</div>