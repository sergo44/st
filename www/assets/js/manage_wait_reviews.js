$(document).ready(function() {

    $("a[data-manage-review-ajax]").click( function(e) {

        e.preventDefault();
        let $that = $(this);

        $.ajax($that.attr("data-ajax-url"), { dataType: "json" })
            .done( (res) => {
                if (res.result.success) {
                    $(this).closest(".wait-review-list-item").fadeOut(500, function() {
                        $(this).closest(".wait-review-list-item").remove();
                        if ( !$("#waitReviewsList li").length ) {
                            $("#waitReviewsList").replaceWith("Отзывы, ожидающие модерацию не найдены");
                        }

                    });
                } else {
                    alert(res.result.errors_as_string);
                }
            })
            .fail(() => {
                alert("Произошла непредвиденная ошибка при выполнении запроса к серверу");
            })

    });
});