<?php use Epoque\Chameleon\Daemon; ?>
<div class="row mainRow">
    <section class="col-md-8 col-md-offset-1 col-lg-offset-2">
        <header>
            <h2>Todo List</h2>
        </header>

        <?php Daemon::contents(PHP_DIR.'mainMenuDropdown.php'); ?>

      <div class="row">
        <div class="col-xs-9 col-md-10">
            <input id="todoListInput" type="text">
        </div>
        <div class="col-xs-2 col-md-2">
            <button id="addToTodoList" class="btn btn-primary">Add</button>
        </div>
      </div>
            
        <ul id="todoList"></ul>

    </section>
  
    <div id="todoListConfirmDeleteModal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Remove Item from Todo List</h4>
          </div>
          <div class="modal-body">
            <p id="confirmModalP"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Keep</button>
            <button id ="confirmDeleteBtn" type="button" class="btn btn-primary" data-dismiss="modal">Delete</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script src="<?php echo JS_DIR.'todoList.js'; ?>"></script>
</div>
