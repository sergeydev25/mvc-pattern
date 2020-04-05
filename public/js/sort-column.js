$(function () {
    const DIRECTION_ASC = 'asc';
    const DIRECTION_DESC = 'desc';

    let currentSortColumn = null;
    let currentDirection = null;
    let currentPage = 1;
    let urlParams = {};

    let sortable = function() {
        window.location.search
            .replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) {
                    urlParams[decodeURI(key)] = value;
                }
            );

        if (urlParams['sort[column]']) {
            currentSortColumn = urlParams['sort[column]'];
        }

        if (urlParams['sort[direction]']) {
            currentDirection = urlParams['sort[direction]'];
        }

        if (urlParams['page']) {
            currentPage = urlParams['page'];
        }

        if (currentSortColumn && currentDirection) {
            let icon = $("#"+currentSortColumn).find("i");
            icon.removeClass("fa-sort");
            if (currentDirection === DIRECTION_ASC) {
                icon.addClass("fa-sort-down");
            } else {
                icon.addClass("fa-sort-up");
            }
        }
    };

    sortable();
    $(".sort-column").click(function() {
        let sortColumn = $(this).attr('id');
        let direction = DIRECTION_ASC;
        if (sortColumn === currentSortColumn && currentDirection === DIRECTION_ASC) {
            direction = DIRECTION_DESC;
        }

        window.location.href = "/?sort[column]="+sortColumn+"&sort[direction]="+direction+"&page="+currentPage;
    });
});
