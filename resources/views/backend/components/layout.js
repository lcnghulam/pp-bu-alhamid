const getdata = (url) => {
    $.ajax({
        url: url,
        method: 'GET',
        success: function (data) {
            $('#layoutPanel').html(data)
            window.history.pushState(null, "", url);
        },
        error: function (data) {
            console.log(data)
        }
    })
}

document.addEventListener("DOMContentLoaded", function() {
    $('a.sidebar-link').on('click', function (event) {
        event.preventDefault();

        let href = $(this).attr('href');
        getdata(href);

        window.onpopstate = function() {
            getdata(window.location.pathname);
        };
    })
});