/* Global APP */

(function () {
    $(function() {
        $( "#news-tabs" ).tabs();
    });
    
    // Updating News.

    (function updateTopNews() {
        var topNews = document.getElementById('top-news');
        
        $.ajax({
            url: APP.requestURL,
            method: 'POST',
            data: {'top-news': true},
            success: function (data, textStatus, jqXHR) {
                topNews.innerHTML = data;
            }
        });
        
        window.setTimeout(updateTopNews, 600000);
    }());
    
    (function updateBizNews() {
        var bizNews = document.getElementById('biz-news');
        
        $.ajax({
            url: APP.requestURL,
            method: 'POST',
            data: {'biz-news': true},
            success: function (data, textStatus, jqXHR) {
                bizNews.innerHTML = data;
            }
        });
        
        window.setTimeout(updateBizNews, 600000);
    }());
    
    (function updateWorldNews() {
        var worldNews = document.getElementById('world-news');
        
        $.ajax({
            url: APP.requestURL,
            method: 'POST',
            data: {'world-news': true},
            success: function (data, textStatus, jqXHR) {
                worldNews.innerHTML = data;
            }
        });
        
        window.setTimeout(updateWorldNews, 600000);
    }());
    

}());

console.log('news.js loaded');
