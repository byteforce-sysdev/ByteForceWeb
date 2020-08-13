$(document).ready(function () {
    AOS.init(
        {
            duration: 500,
            easing:'ease-in-out',
            once:true
        }
    );

    var fixedButton = $("#fixedButton");
    var scrolledPastLanding = false;

    $(document).on('scroll', function() {
        if($(this).scrollTop() >= $('#our-solutions').position().top){
            fixedButton.css("visibility", "visible");
            fixedButton.css("opacity", 1);
            scrolledPastLanding = true;
        } else if ($(this).scrollTop() < $('#our-solutions').position().top && scrolledPastLanding){
            scrolledPastLanding = false;
            fixedButton.css("opacity", 0);
            setTimeout(function() {
                fixedButton.css("visibility", "hidden");
            }, 300);
        }
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF_TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    var messageError = $("#messageError");
    messageError.css("visibility","hidden");

    $(".btnmodal").click(function(){
        $(".modal").css("display","block");
    });
    $(".close").click(function(){
        $(".modal").css("display","none");
        messageError.css("visibility","hidden");
    });
    $(window).click(function(e){
        if($(e.target).is(".modal")){
            $(".modal").css("display","none");
            messageError.css("visibility","hidden");
        }
    });
    $("#btnSendContactUs").click(function (e) {

        var contactName = $("#contactName").val();
        var contactEmail = $("#contactEmail").val();
        var contactMessage = $("#contactMessage").val();

        if (!contactName || !contactEmail || !contactMessage) {
            messageError.text("Please complete the form.");
            messageError.css("visibility","visible");
        } else {
            messageError.css("visibility","hidden");
            var button = $(this);
            button.val("Sending...");
            button.attr("disabled", true);

            $.ajax({
                type: "POST",
                contentType: 'application/json',
                url: "/contact-us/new",
                dataType: "json",
                data: JSON.stringify({
                    "_token": $('meta[name="csrf-token"]').attr("content"),
                    "contactName": contactName,
                    "contactEmail": contactEmail,
                    "contactMessage": contactMessage
                }),
                success: function (json) {
                    button.val("Sent");
                    button.addClass("bttn-disabled");
                    button.attr("disabled", true);
                },
                error: function (xhr, status, error) {
                    messageError.css("visibility","visible");
                    messageError.text("Something went wrong. Please try again later.");
                    button.val("Send");
                    button.attr("disabled", false);
                }
            });
        }
    });

});