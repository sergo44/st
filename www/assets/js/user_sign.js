$(document).ready(function() {

    let stRegisterForm = $("#jsRegisterForm");
    let jsSignInWidget = $("#jsSignInWidget");

    stRegisterForm.submit(function(e) {
        e.preventDefault();

        let that = this;
        let submitFormBtn = $(that).find("button[type=submit]");
        let submitFormBtnLabel = submitFormBtn.html();
        let jsRegisterModal = bootstrap.Modal.getInstance(document.getElementById("regForm"));

        $.ajax({
            url: "/Api/User/Register/Go",
            data: $(that).serialize(),
            dataType: "json",
            method: "post",
            beforeSend: function() {
                submitFormBtn.prop("disabled", true).html("Выполняется регистрация...");
            },
            complete: function() {
                submitFormBtn.prop("disabled", false).html(submitFormBtnLabel);
            },
            error: function() {
                alert("Произошла непредвиденная ошибка при отправке данных на сервер. Проверьте пожалуйста соединение с интернетом и попробуйте еще раз");
            },
            success: function(res) {

                stRegisterForm.find(".st-form-error").remove();

                if (res.result.success) {
                    jsSignInWidget.fadeTo("normal", 0.1, function() {
                        jsSignInWidget.replaceWith(res.replaceWithHtml);
                        jsSignInWidget.fadeIn();
                    });

                    that.reset();
                    jsRegisterModal.hide();
                } else {
                    let unClassifiedErr = [];

                    $(res.result.errors).each(function() {
                        if (!this.field) {
                            unClassifiedErr.push(this)    ;
                        } else {
                            let el = stRegisterForm.find("input[name=" + this.field + "]");

                            if (el.length) {
                                el.after($("<div class='alert alert alert-danger st-form-error mt-3'>"+this.message+"</div>"));
                            } else {
                                unClassifiedErr.push(this);
                            }
                        }

                    });

                    if (unClassifiedErr.length) {
                        let err = $("<ul>");
                        $(that).parent(".modal-body").prepend($("<div>", {class: "alert alert-danger st-form-error"}).html(err));
                        unClassifiedErr.forEach(function(v) {
                            err.append("<li> " + v.message);
                        });
                    }
                }
            }
        });
    });
});