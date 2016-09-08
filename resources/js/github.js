/* global APP */

(function () {
    var section = document.getElementById('github');
    var repoButtons = document.getElementsByClassName('repo-btn');

    var refreshGithubSection = function() {
        $.ajax({
            url: 'RequestHandler.php',
            data: { 'github' : 'section' },
            success: function (data, textStatus, jqXHR) {
                section.innerHTML = data;
                assignRepoButtonAction();
            }
        });
    };

    var repoButtonAction = function (x) {
        section.innerHTML = '<h3>' + x.target.id + '</h3>';
        section.innerHTML += '<button type="button" id="'+x.target.id+'-branches" class="btn btn-primary">Branches</button>';
        section.innerHTML += '<button type="button" id="repo-back-btn" class="btn btn-primary">Go Back</button>';

        document.getElementById(x.target.id+'-branches').addEventListener('click',
            function () {
                $.ajax({
                    url: APP.requestURL,
                    data: {'github': 'branch,'+x.target.id},
                    success: function (data, textStatus, jqXHR) {
                        section.innerHTML += data;
                    }
                });
            }
        );

        document.getElementById('repo-back-btn').addEventListener('click',
            function () {
                refreshGithubSection();
            }
        );
    };
    
    var assignRepoButtonAction = function () {
        for (var i = 0; i < repoButtons.length; i++) {
            repoButtons.item(i).addEventListener('click', repoButtonAction);
            //console.log(repoButtons.item(i));
        }
    };
    

    
    refreshGithubSection();
}());
console.log('github.js loaded');
