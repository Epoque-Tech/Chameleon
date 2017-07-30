(function () {
    var
    requestUrl = 'resources/requests/draft.php',

    /** @var The id of the current draft. If undefined, the draft is new. **/
    draftId = undefined,

    /** @var The title of the current draft. **/
    title = undefined,

    /** @var The markdown of the current draft. **/
    markdown = undefined,

    /** @var The mode of the current draft. **/
    mode = 'unpub', // or pub.

    /** @var A containter for draft data (id,title,published,mod_epoque). **/
    index = undefined,

    /** @var Holds all the titles for published and unpublished drafts. **/
    titles = [],


    /** HTML elements markup. **/
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
            data: {'index':true}
        }).done(data => {
            index = JSON.parse(data);
            recordTitles();
        }).then( () => {
            populateDraftLinks(mode);
        });
    },


    /**
     * recordTitles
     *
     * Populates the titles container with the draft titles in the
     * index.
     */

    recordTitles = () => {
        index.forEach(entry => {
            titles.push(entry.title);
        });
    },


    /**
     * populateDraftLinks
     *
     * Populates the draft-links div in the sidebar with buttons for
     * each unpublished draft. Assigns action to the buttons.
     *
     * @param {string} type Either pub (published) or unpub.
     */

    populateDraftLinks = (type) => {
        var btns = '';
        var request = {};

        index.forEach( entry => {
            if (type === 'unpub' && !entry.published) {
                btns += `<button id="${entry.id}" class="btn btn-default draft-link">${entry.title}</button>`;
            }
            else if (type === 'pub' && entry.published) {
                btns += `<button id="${entry.id}" class="btn btn-default draft-link">${entry.title}</button>`;
            }
        });

        $('#draft-links').empty();
        $('#draft-links').html(btns);

        $('.draft-link').click( Event => {
            draftId = Event.target.id;
            request['/draft/'+type] = draftId;

            $.ajax({
                url: requestUrl,
                data: request
            }).done( draft => {
                draft = JSON.parse(draft);

                $('#draft-title').val(draft.title);
                $('#draft-markdown').val(draft.content);
            });
        });
    },


    /**
     * populateDraftBtns
     *
     * Places UI buttons for the current draft in the #draft-btns div.
     */

    populateDraftBtns = () => {
        var draftBtns = saveBtn + previewBtn + publishBtn + deleteBtn;
        $('#draft-btns').html(draftBtns);
        setDraftBtnActions();
    },


    /**
     * setDraftBtnActions
     *
     * Sets the actions of the buttons in the #draft-btns div.
     */

    setDraftBtnActions = () => {
        $('#save-draft').click(save);
        $('#preview-draft').click(preview);
    },


    /**
     * populateDraftMarkdown
     *
     * Places a textarea element in the #draft-display div and fills it
     * with the markdown var if data is stored in it.
     */

   populateDraftMarkdown = () => {
        markdown = markdown || '';

        $('#draft-display').empty();
        $('#draft-display').html('<textarea id="draft-markdown" class="form-control">'+markdown+'</textarea>');
        $('#draft-markdown').attr('contentEditable', true);
        $('#draft-markdown').keydown( e => {
            if (e.keyCode === 13) {
              //disable enter
              //document.execCommand('insertHTML', false, '\n');
              //return false;
            }
        });
   },


    /**
     * validInput
     *
     * Validates the current draft input (title and markdown).
     *
     * @returns {boolean} True if valid, false otherwise.
     */

    validInput = () => {
        var valid = true;

        if (!validTitle() || !validContent()) {
            valid = false;
        }

        return valid;
    },


    /**
     * validTitle
     *
     * Validates the draft title.
     *
     * Title cannot be empty, greater than 64 characters, nor
     * an existing title if draft is new.
     *
     * @returns {Boolean} True if the title is valid, false otherwise.
     */

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

        else if (!draftId && titles.includes(title)) {
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


    /**
     * validContent
     *
     * Validates the #draft-markdown; must have content.
     *
     * @returns {Boolean} True if there's content in the #draft-markdown,
     * false otherwise.
     */

    validContent = () => {
        var response = true;
        var lenContent = ($('#draft-markdown').val()).length;

        if (lenContent === 0) {
            $('#draft-display').addClass('has-error');
            response = false;
        }
        else {
            $('#draft-display').removeClass('has-error');
        }

        return response;
    },


    confirmSave = () => {
        console.log('Draft saved.');
    },


    /**
     * newDraft
     *
     * The action for the #new-draft-btn.
     */

    newDraft = () => {
        draftId = title = markdown = undefined;
        mode = 'unpub';

        $('#draft-title').val('');
        $('#draft-markdown').val('');
    },


    /**
     * save
     *
     * The save button action.
     *
     * @param {type} Event The click event that triggers save.
     */

    save = Event => {
        if (validInput()) {
            markdown = $('#draft-markdown').val();

            if (mode === 'unpub' && draftId === undefined) {
                saveUnpubNew();
            }

            else if (mode === 'unpub' && draftId) {
                saveUnpubExist();
            }
        }
    },


    saveUnpubNew = () => {
        $.ajax({
            url: requestUrl,
            method: 'POST',
            data : {'/save/unpub/new' : JSON.stringify({
                    title : $('#draft-title').val(),
                    content : $('#draft-markdown').html()
                })
            }
        }).done( (data) => {
            confirmSave();
            // data is the id of the new draft.
            draftId = data;
            window.onload();
        });
    },


    saveUnpubExist = () => {
        $.ajax({
            url: requestUrl,
            method: 'POST',
            data: {
                '/save/unpub/exist': {
                    id : draftId,
                    title: $('#draft-title').val(),
                    content: $('#draft-markdown').html()
                }
            }
        }).done( (data) => {
            confirmSave();
            window.onload();
        });
    },


    /**
     * preview
     *
     * The preview button action.
     */

    preview = () => {
        console.log($('#draft-markdown').val());
    };


    /**
     * window.onload
     *
     * The onload or reload function.
     */

    window.onload = () => {
        reindex();

        $('#new-draft-btn').click(newDraft);

        $('#draft-select-pub').click( () => {
            populateDraftLinks('pub');
        });

        $('#draft-select-unpub').click( () => {
            populateDraftLinks('unpub');
        });

        populateDraftMarkdown();
        populateDraftBtns();

        if (!draftId) $('#draft-title').val('');
        if (!markdown) $('#draft-markdown').val('');

        // This is hidden on purpose.
        $('#draft-title-error').hide();
    };

}());

console.log('draft.js loaded');
