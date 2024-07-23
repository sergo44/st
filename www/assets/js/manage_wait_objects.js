$(document).ready(function() {

    $("[data-manage-object]").click(function(e) {
        e.preventDefault();

        let $that = $(this);

        $.ajax($that.attr("data-ajax-url"))
            .done(function(res) {
                if (res.result.success) {
                    $that.parents("li:eq(1)").fadeOut(500, function() {
                        $that.parents("li:eq(1)").remove();
                        if ($("#waitObjectsList li").length === 0) {
                            $("#waitObjectsList").replaceWith("<div class=\"m-1\">Вы обработали все объекты</div>");
                        }
                    });
                } else {
                    alert(res.result.errors_as_string);
                }
            })
            .fail(function() {
                alert("Произошла непредвиденная ошибка при выполнении запроса к серверу")
            })
        ;

    })

});