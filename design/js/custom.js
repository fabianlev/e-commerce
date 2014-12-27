(function($){
    /* Carousel */
    $('.carousel').carousel({
        interval: 5000,
        pause: "hover"
    });

    /* Navigation */

    ddlevelsmenu.setup("ddtopmenubar", "topbar");

    $("<select />").appendTo(".navis");

    $("<option />", {
        "selected": "selected",
        "value"   : "",
        "text"    : "Menu"
    }).appendTo(".navis select");


    $(".navi a").each(function() {
        var el = $(this);
        $("<option />", {
            "value"   : el.attr("href"),
            "text"    : el.text()
        }).appendTo(".navis select");
    });

    $(".navis select").change(function() {
        window.location = $(this).find("option:selected").val();
    });



    /* Scroll to Top */


    $(".totop").hide();

    $(window).scroll(function(){
        if ($(this).scrollTop()>300)
        {
            $('.totop').fadeIn();
        }
        else
        {
            $('.totop').fadeOut();
        }
    });

    $('.totop a').click(function (e) {
        e.preventDefault();
        $('body,html').animate({scrollTop: 0}, 500);
    });


    $(document).ready(function() {
        $('.sidey .nav').navgoco();
    });

    // aJax CartAdd
    $('.addCart').click(function(event){
        event.preventDefault();
        $.get($(this).attr('href'),{},function(data){
            if(data.error){
                alert(data.message);
            } else {
                $('#total').empty().append(data.total);
                $('#count').empty().append(data.count);
                $('#modalCart').empty().append(data.modal);
            }
        }, 'json');
    });

    $('#addCartQuantity').click(function(event){
        event.preventDefault();
        $quantity = $('#itemQuantity').val();
        if($quantity != 0){
            $link = $(this).attr('href') + '&quantity=' + $quantity;
            $.get($link,{},function(data){
                if(data.error){
                    alert(data.message);
                } else {
                    $('#total').empty().append(data.total);
                    $('#count').empty().append(data.count);
                    $('#modalCart').empty().append(data.modal);
                }
            }, 'json');
        } else {
            alert('Vous devez ajouter au moins 1 article au panier');
        }
    });

})(jQuery);
