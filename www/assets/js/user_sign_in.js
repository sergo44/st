$(document).ready(function() {

    let jsSignInForm = $("#jsSignInForm");
    let signInModal = $("#entryForm");
    let jsSignInWidget = $("#jsSignInWidget");

    signInModal.get(0).addEventListener("hidden.bs.modal", function() {
        signInModal.find("form").get(0).reset();
        signInModal.find(".st-form-error").remove();
    });

    jsSignInForm.submit(function(e) {
        e.preventDefault();

        let that = this;
        let submitBtn = $(that).find("button[type=submit]");
        let signInModalInstance = bootstrap.Modal.getInstance(document.getElementById("entryForm"));


        $.ajax({
            url: "/Api/User/SignIn/Go",
            data: $(that).serialize(),
            dataType: "json",
            success: function(res) {
                signInModal.find(".st-form-error").remove();

                if (res.result.success) {
                    jsSignInWidget.fadeTo("normal", 0.1, function() {
                        jsSignInWidget.replaceWith(res.replaceWithHtml);
                        jsSignInWidget.fadeIn();
                    });
                    that.reset();
                    signInModalInstance.hide();

                } else {
                    $(that).parent(".modal-body").prepend($("<div>", {class: "alert alert-danger st-form-error"}).html($("<ul>", {class: "alert-error"})));
                    let err = $(that).parent(".modal-body").find("ul.alert-error");
                    res.result.errors.forEach(function(v) {
                        err.append("<li> " + v.message);
                    });
                }

            },
            error: function() {
                alert("Произошла непредвиденная ошибка при выполнении запроса к серверу");
            },
            beforeSend: function() {
                submitBtn.prop("disabled", true);
            },
            complete: function() {
                submitBtn.prop("disabled", false);
            }
        });
    });
});