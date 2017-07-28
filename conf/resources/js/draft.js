(function () {
    var
    requestUrl = 'resources/requests/draft.php',

    mode = 'unpub', // or pub.

    draftId = undefined, // or the row id of an exist draft.

    markdown = '',
    
    /** @var A containter for draft data (id,title,published,mod_epoque). **/
    index = undefined,

    /** @var Holds all the titles for published and unpublished drafts. **/
    titles = [],
    
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
    
    
    /**
     * reindex
     *
     * Fetches the index data (id,title,published,mod_epoque) from the
     * server, populates links and records all the titles in titles var.
     */

    reindex = () => {
        $.ajax({
            url: requestUrl,
            data: {'index':true},
            success: data => {
                index = JSON.parse(data);
                recordTitles();
                populateUnpubLinks();
                // populatePubLinks();
            }
        });
    },
    
    
    recordTitles = () => {
        index.forEach(entry => {
            titles.push(entry.title);
        });
    },
    
    
    populateUnpubLinks = () => {
        var btns = '';
        
        index.forEach( entry => {    
            if (!entry.published) {
                btns += `<button id="${entry.id}" class="btn btn-default">${entry.title}</button>`;
            }
        });
        
        $('#draft-links').html(btns);
    },


   populateDraftMarkdown = () => {
        markdown = markdown || '';

        $('#draft-display').empty();
        $('#draft-display').html('<pre id="draft-markdown" class="form-control">'+markdown+'</pre>');
        $('#draft-markdown').attr('contentEditable', true);
        $('#draft-markdown').keydown( e => {
            if (e.keyCode === 13) {
              document.execCommand('insertHTML', false, '\n');
              return false;
            }
        });
   },


    populateDraftBtns = () => {
        var draftBtns = saveBtn + previewBtn + publishBtn + deleteBtn;
        $('#draft-btns').html(draftBtns);
        setDraftBtnActions();
    },


    setDraftBtnActions = () => {
        $('#save-draft').click(save);
    },


    validInput = () => {
        var valid = true;

        valid = validTitle();
        valid = validContent();

        return valid;
    },


    validTitle = () => {
        var response = true;
        var title = $('#draft-title').val();
        var lenTitle = title.length;

        if (lenTitle === 0) {
            response = false;
            $('#draft-title-input').addClass('has-error');
            $('#draft-title-error').html('title required');
            $('#draft-title-error').show();
        }

        else if (lenTitle > 64 ) {
            response = false;
            $('#draft-title-input').addClass('has-error');
            $('#draft-title-error').html('title too long');
            $('#draft-title-error').show();
        }
        
        else if (titles.includes(title)) {
            response = false;
            $('#draft-title-input').addClass('has-error');
            $('#draft-title-error').html('title already used');
            $('#draft-title-error').show();
        }

        else {
            $('#draft-title-input').removeClass('has-error');
            $('#draft-title-error').html('');
            $('#draft-title-error').hide();
        }

        return response;
    },


    validContent = () => {
        var response = true;
        var lenContent = ($('#draft-markdown').text()).length;

        if (lenContent === 0) {
            $('#draft-display').addClass('has-error');
            response = false;
        }
        else {
            $('#draft-display').removeClass('has-error');
        }

        return response;
    },


    save = Event => {
        if (validInput()) {
            markdown = $('#draft-markdown').text();

            if (mode === 'unpub' && draftId === undefined) {
                saveUnpubNew();
            }
        }

        window.onload();
    },


    saveUnpubNew = () => {
        $.ajax({
            url: requestUrl,
            method: 'POST',
            data : {'/save/unpub/new' : JSON.stringify({
                    title : $('#draft-title').val(),
                    content : $('#draft-markdown').html()
                })
            },
            success : data => {
                // data is the id of the new draft.
                draftId = data;
            },
            fail : err => {
                console.log(err);
            }
        });
    },
    

    saveUnpubExist = () => {
        var request = {};
        
        $.ajax({
            url: requestUrl,
            method: 'POST',
            data: {
                '/save/unpub/exist': {
                    id : draftId,
                    title: $('#draft-title').val(),
                    content: $('#draft-markdown').html()
                }
            },
            success: data => {
                console.log(data);
            }
        });
    };


    window.onload = () => {
        reindex();
        
        populateDraftMarkdown();
        populateDraftBtns();
        
        $('#draft-title-error').hide();
    };

}());
console.log('draft.js loaded');

