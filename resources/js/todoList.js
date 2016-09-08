/* global APP */

(function () {
    APP.debug = true;
    
    var cachedList = {};
    var ids = [];
    var delItem = '';


    var printList = function () {
        var todoListHtml = '';

        for (var id in cachedList) {
            todoListHtml += '<li id="' + id + '">' + cachedList[id] + '</li>';
            ids.push(id);
        }

        $('#todoList').html(todoListHtml);

        ids.forEach(function (e) {
            $('#' + e).click(confirmDelete);
        });
    };


    var getList = function () {
        $.ajax({
            url : APP.requestURL,
            method : 'POST',
            data : { 'getTodoList' : true },
            success : function (data) {
                cachedList = JSON.parse(data);
                printList();
                updateList();
            }
        });
        
        window.setTimeout(getList, 5*1000);
    };


    var addItem = function () {
        var newItem = {};
        var nitem = $('#todoListInput').val();
        var nid = nitem.hashCode().toString();

        newItem[nid] = nitem;
        $('#todoListInput').val('');            

        for (var id in newItem) {
            cachedList[id] = newItem[id];
            updateList();
            printList();
        }
    };


    var confirmDelete = function () {
        delItem = this.id;
        $('#confirmModalP').html('Are you sure you want to delete <span style="color:blue;">' + cachedList[this.id] + '</span>?');
        $('#todoListConfirmDeleteModal').modal('show');
    };


    var removeItem = function (id) {
        delete cachedList[delItem];
        updateList();
        printList();
    };


    var updateList = function () {
        if (!$.isEmptyObject(cachedList)) {
            $.ajax({
                url: APP.requestURL,
                method : 'POST',
                data : { 'updateTodoList' : cachedList },
                success : function (data) {
                    if (APP.debug) {
                        console.log(data);
                    }
                }
            });
        }
        else {
            $.ajax({
                url: APP.requestURL,
                method : 'POST',
                data : { 'updateEmptyTodoList' : true },
                success : function (data) {
                    if (APP.debug) {
                        console.log(data);
                    }
                }
            });
        }
    };

    getList();

    $('#addToTodoList').click(addItem);
    $('#confirmDeleteBtn').click(removeItem);
    $('#todoListInput').keyup(function (e) {
        if (e.keyCode === 13) {
            addItem();
        }
    });

}());

console.log('todoList.js loaded');
