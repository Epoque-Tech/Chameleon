<?php if ($_SERVER['REMOTE_ADDR'] !== '72.234.164.107') header('Location: /');; ?>
<h1>Edit Post Drafts</h1>

<div class="col-md-2">
    <div><button id="new-draft-btn" class="btn btn-primary">New Draft</button></div>
    <br>
    <div id="draft-select">
        <button id="draft-select-draft" class="btn btn-default">Drafts</button>
        <button id="draft-select-pub" class="btn btn-default">Posts</button>
    </div>
    <br>
    <div id="draft-links" class="btn-group-vertical" role="group" aria-label="...">
    </div>
</div>

<div class="col-md-9">
    <div id="draft-btns" class="btn-group" role="group" aria-label="..."></div>
    <br><br>
    <div id="draft-display"></div>
</div>
