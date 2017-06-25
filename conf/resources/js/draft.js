(function () {
    var
    requestUrl = 'resources/requests/draft.php',

    markdownHolder = '',

    saveBtn =
        `<div class="btn-group" role="group" aria-label="...">
          <button id="save-draft" type="button" class="btn btn-default">Save</button>
        </div>`,

    publishBtn =
        `<div class="btn-group" role="group" aria-label="...">
          <button id="publish-draft" type="button" class="btn btn-primary">Publish</button>
        </div>`,

    previewBtn =
        `<div class="btn-group" role="group" aria-label="...">
          <button id="preview-draft" type="button" class="btn btn-default">Preview</button>
        </div>`,

    editBtn =
        `<div class="btn-group" role="group" aria-label="...">
          <button id="edit-draft" type="button" class="btn btn-default">Edit</button>
        </div>`,

    deleteBtn = 
        `<div class="btn-group" role="group" aria-label="...">
          <button id="delete-draft" type="button" class="btn btn-danger">Delete</button>
        </div>`,

    
    getDraft = function () {
        $.ajax({
            url:requestUrl,
            data:{'draft/id': this.id},
            success: data => {
                populateDraftMarkdown(data);
                $('#draft-btns').html(deleteBtn + previewBtn + saveBtn + publishBtn);
                setBtnActions();
            }
        });
    },

    
    getPub = function () {
        $.ajax({
            url:requestUrl,
            data:{'pub/id': this.id},
            success: data => {
                populateDraftMarkdown(data);
                $('#draft-btns').html(deleteBtn + previewBtn + saveBtn + publish);
                setBtnActions();
            }
        });
    },


   populateDraftMarkdown = function (markdown) {
	$('#draft-display').empty();
        $('#draft-display').html('<pre id="draft-markdown">'+markdown+'</pre>');
        $('#draft-markdown').attr('contentEditable', true);
        $('#draft-markdown').keydown(function(e) {
            if (e.keyCode === 13) {
              document.execCommand('insertHTML', false, '\n');
              return false;
            }
        });
   },


   populateDraftLinks = function (links) {
       var request = {};
       request[links] = true;

        $.ajax({
            url:requestUrl,
            data: request,
            success: data => {
                $('#draft-links').html(data);
                $('#draft-links button').click(getDraft);
                $('#draft-links button').first().trigger('click');
            }
        });
   },
    
    
    preview = function () {
        markdownHolder = $('#draft-markdown').html();

        $.ajax({
            url:requestUrl,
            data:{'draft/preview':markdownHolder},
            success : data => {
                $('#draft-display').html(data);
                $('#draft-btns').html(deleteBtn + editBtn + saveBtn);
                setBtnActions();
            }
        });
    },
    
    
    edit = function () {
        populateDraftMarkdown(markdownHolder);
        $('#draft-btns').html(deleteBtn + previewBtn + saveBtn);
        setBtnActions();
    },
    
    
    setBtnActions = function () {
        $('#preview-draft').click(preview);
        $('#edit-draft').click(edit);
    };

    
    window.onload = function () {
        $('#draft-select-draft').click(function () {
            populateDraftLinks('draft/links');
        });

        $('#draft-select-pub').click(function () {
            populateDraftLinks('pub/links');
        });

        $('#draft-select-draft').trigger('click');
    };

}());
console.log('draft.js loaded');
