<h1>Edit Post Drafts</h1>

<div class="col-md-2">
    <div><button id="new-draft-btn" class="btn btn-primary">New Draft</button></div>
    <br>
    <div id="draft-select">
        <button id="draft-select-draft" class="btn btn-default">Unpublished</button>
        <button id="draft-select-pub" class="btn btn-default">Published</button>
    </div>
    <br>
    <div id="draft-links" class="btn-group-vertical" role="group" aria-label="...">
    </div>
</div>

<div class="col-md-9">

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
