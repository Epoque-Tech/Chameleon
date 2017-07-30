<div id="draft-row" class="row">
    <h1>Edit Post Drafts</h1>

    <div class="col-md-2">
        <div><button id="new-draft-btn" class="btn btn-primary">New Draft</button></div>
        <br>
        <div id="draft-select">
            <button id="draft-select-unpub" class="btn btn-default">Unpublished</button>
            <button id="draft-select-pub" class="btn btn-default">Published</button>
        </div>
        <br>
        <div id="draft-links" class="btn-group-vertical" role="group" aria-label="...">
        </div>
    </div>

    <div id="draft-main" class="col-md-9">

        <div id="draft-btns" class="btn-group" role="group" aria-label="..."></div>
        <br><br>

        <label class="sr-only" for="draft-title">Title</label>
        <div id="draft-title-input" class="input-group">
          <div class="input-group-addon">Title</div>
          <input type="text" id="draft-title" class="form-control">
          <div id="draft-title-error" class="input-group-addon">Title too long.</div>
        </div>

        <div id="draft-display" class="input-group" style="width:100%;"></div>

    </div>
</div>


<div id="draft-modal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="draft-modal-title" class="modal-title">Modal title</h4>
      </div>
      <div id="draft-modal-body" class="modal-body"></div>
      <div id="draft-modal-footer" class="modal-footer"></div>
    </div>
  </div>
</div>
