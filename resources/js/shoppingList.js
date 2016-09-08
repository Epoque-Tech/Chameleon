/* global APP */

(function () {
    var cachedList = {};
    var ids = [];
    var delItem = '';


    var printList = function () {
        var shoppingListHtml = '';

        for (var id in cachedList) {
            shoppingListHtml += '<li id="' + id + '">' + cachedList[id] + '</li>';
            ids.push(id);
        }

        $('#shoppingList').html(shoppingListHtml);

        ids.forEach(function (e) {
            $('#' + e).click(confirmDelete);
        });
    };


    var getList = function () {
        $.ajax({
            url : APP.requestURL,
            method : 'POST',
            data : { 'getShoppingList' : true },
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
        var nitem = $('#shoppingListInput').val();
        var nid = nitem.hashCode().toString();

        newItem[nid] = nitem;
        $('#shoppingListInput').val('');            

        for (var id in newItem) {
            cachedList[id] = newItem[id];
            updateList();
            printList();
        }
    };


    var confirmDelete = function () {
        delItem = this.id;
        $('#confirmModalP').html('Are you sure you want to delete <span style="color:blue;">' + cachedList[this.id] + '</span>?');
        $('#shoppingListConfirmDeleteModal').modal('show');
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
                data : { 'updateShoppingList' : cachedList },
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
                data : { 'updateEmptyShoppingList' : true },
                success : function (data) {
                    if (APP.debug) {
                        console.log(data);
                    }
                }
            });
        }
    };

    getList();

    $('#addToShoppingList').click(addItem);
    $('#confirmDeleteBtn').click(removeItem);
    $('#shoppingListInput').keyup(function (e) {
        if (e.keyCode === 13) {
            addItem();
        }
    });

}());

console.log('shoppingList.js loaded');
