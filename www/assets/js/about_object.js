import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";

$(document).ready(function() {

    let $jsOrderRoomModal = $("#jsOrderRoomModal");
    let $jsOrderRoomModalForm = $jsOrderRoomModal.find("form");

    $jsOrderRoomModalForm.on("submit", function(e) {
        e.preventDefault();

        let that = this;
        let $buttons = $(this).find("button");
        let $submitBtn = $buttons.last();
        let submitLabel = $submitBtn.html();

        $.ajax({
            url: $(that).attr("action"),
            type: "post",
            dataType: "json",
            data: new FormData(that),
            processData: false,
            contentType: false,
            error: function() {
                alert("Произошла непредвиденная ошибка при выполнении запроса к серверу, пожалуйста проверьте наличие интернета и попробуйте еще раз");
            },
            success: function(res) {
                if (res.result.success) {
                    alert("Ваша заявка успешно отправлена. В ближайшее время с вами свяжется администратор удобным для Вас способом");
                    let modal = bootstrap.Modal.getInstance($jsOrderRoomModal[0]);
                    modal.hide();
                } else {
                    alert(res.result.errors_as_string);
                }
            },
            beforeSend: function() {
                $buttons.prop("disabled", true);
                $submitBtn.html("Идет отправка данных ...");

            },
            complete: function() {
                $buttons.prop("disabled", false);
                $submitBtn.html(submitLabel);
            }
        });
    });


    $jsOrderRoomModal[0].addEventListener("show.bs.modal", function(e) {
        $jsOrderRoomModalForm.find("input[name=hotel_room_id]").val( $(e.relatedTarget).attr("data-hotel-room-id") );
    });

    $jsOrderRoomModal[0].addEventListener("hide.bs.modal", function(e) {
        $jsOrderRoomModalForm[0].reset();
    });

    let $addReviewModal = $("#jsAddReviewModal");
    let $addReviewForm = $addReviewModal.find("form").first();
    let $buttons = $addReviewForm.find("button");

    $addReviewForm.on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr("action"),
            type: "post",
            dataType: "json",
            data: new FormData(this),
            processData: false,
            contentType: false,
            error: function() {
                alert("Произошла непредвиденная ошибка при выполнении запроса к серверу, пожалуйста проверьте наличие интернета и попробуйте еще раз");
            },
            success: function(res) {
                if (res.result.success) {
                    alert("Ваш отзыв добавлен и будет виден другим, когда его одобрит администратор разделе");
                    let modal = bootstrap.Modal.getInstance($addReviewModal[0]);
                    modal.hide();
                } else {
                    alert(res.result.errors_as_string);
                }
            },
            beforeSend: function() {
                $buttons.prop("disabled", true);

            },
            complete: function() {
                $buttons.prop("disabled", false);
            }
        });
    });

    $addReviewModal[0].addEventListener("hide.bs.modal", function(e) {
        $addReviewForm[0].reset();
    });

    Fancybox.bind("[data-fancybox]", {
        // Your custom options
    });
});