import Cropper from "cropperjs";

$(document).ready(function() {
    let uploaded_image = 0;
    let cropper;

    $("#jsUploadImageBtn").click(function(e) {
        e.preventDefault();
        $("#jsUploadImageForm").trigger("submit");
    });

    $("#jsSelectFileInt").change(function(e) {
        $("#jsUploadImageForm").trigger("submit");
    });

    let jsAddImageModal = document.getElementById("jsAddImageModal");
    jsAddImageModal.addEventListener("hidden.bs.modal", function(e) {
        $("#jsSetAreaImage").attr("src", "/images/no-image.svg");
        $("#jsSetAreaBtn").unbind("click");
    });

    $("#jsUploadImageForm").on("submit", function(e) {
        e.preventDefault();

        let that = this;
        let $jsUploadImageErrorCnt = $("#jsUploadImageErrorCnt");

        $.ajax({
            url: "/Images/Upload/CatalogObject",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function() {
                $jsUploadImageErrorCnt.removeClass("alert alert-danger").html(null);
                $(jsAddImageModal).find("button").prop("disabled", true);
                $(jsAddImageModal).find("button").first().html("Идет загрузка файла на сервер ...");
            },
            complete: function() {
                $(jsAddImageModal).find("button").prop("disabled", false);
                $(jsAddImageModal).find("button").first().html("Загрузить");
            },
            error: function(error) {
                alert("Произошла непредвиденная ошибка при выполнении запроса к серверу.")
            },
            success: function(res) {
                if (!res.result.success) {
                    $jsUploadImageErrorCnt.addClass("alert alert-danger").html("<ul></ul>");
                    $.each(res.result.errors, function(k, v) {
                        $jsUploadImageErrorCnt.find("ul").append("<li>"+v.message+"</li>");
                    });
                    return;
                }

                if (res.result.success) {
                    let image = document.getElementById("jsSetAreaImage");
                    $(image).attr("src", res.file.uri);

                    if (typeof cropper !== "undefined" && cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(image, {
                        aspectRatio: res.ratio,
                        movable: false,
                        rotatable: false,
                        zoomOnWheel: false,
                        viewMode: 1,
                        background: false
                    });

                    $("#jsSetAreaBtn").unbind("click").click(function() {
                        let data = cropper.getData();
                        let jsObjectPhoto = $("#jsObjectPhotos");

                        jsObjectPhoto.append("<img src=\"/" + res.file.directory + "150x150/" + res.file.filename + "?crop=1&x1=" + parseInt(data.x) + "&y1=" + parseInt(data.y) + "&x2=" + parseInt(data.x+data.width) + "&y2=" + parseInt(data.y + data.height)+"\">");
                        jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[directory]["+uploaded_image+"]\" value=\""+res.file.directory+"\">");
                        jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[filename]["+uploaded_image+"]\" value=\""+res.file.filename+"\">");
                        jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[x1]["+uploaded_image+"]\" value=\""+parseInt(data.x)+"\">");
                        jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[y1]["+uploaded_image+"]\" value=\""+parseInt(data.y)+"\">");
                        jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[x2]["+uploaded_image+"]\" value=\""+parseInt(data.x+data.width)+"\">");
                        jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[y2]["+uploaded_image+"]\" value=\""+parseInt(data.y + data.height)+"\">");
                        jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[ratio]["+uploaded_image+"]\" value=\""+res.ratio+"\">");

                        uploaded_image++;

                        let modal = bootstrap.Modal.getInstance(jsAddImageModal);
                        modal.hide();

                        cropper.destroy();
                        $("#jsUploadImageForm")[0].reset();

                    });
                }
            }
        });
    });
});