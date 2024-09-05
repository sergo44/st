import Cropper from "cropperjs";

$(document).ready(function() {

    $("#jsMultiImagesUploaderSelectFileInp").change(function(e) {
        $("#jsMultiImagesUploaderForm").trigger("submit");
    });

    $("#jsMultiImagesUploaderForm").submit(function(e) {
        e.preventDefault();

        let files = $("#jsMultiImagesUploaderSelectFileInp")[0].files;

        if (!files.length) {
            alert("Вы не указали ни одной фотографии для загрузки");
            return;
        }

        uploadFile(files, 0);
    });

    function uploadFile(files, i) {

        let formData = new FormData();
        formData.append("image[]", files[i]);

        let $jsMultiImagesUploaderModal = $("#jsMultiImagesUploaderModal");
        let $jsMultiImagesUploaderErrorCnt = $("#jsMultiImagesUploaderErrorCnt");

        $.ajax({
            url: "/Images/Upload/Sight",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                if (i === 0) {
                    $jsMultiImagesUploaderErrorCnt.removeClass("alert alert-danger").html(null);
                }

                $jsMultiImagesUploaderModal.find("button").prop("disabled", true);
                $jsMultiImagesUploaderModal.find("button").first().html("Идет загрузка файла " + files[i].name + " ...");
            },
            complete: function() {
                if (i >= files.length - 1) {
                    $jsMultiImagesUploaderModal.find("button").prop("disabled", false);
                    $jsMultiImagesUploaderModal.find("button").first().html("Загрузить");
                }
            },
            error: function(error) {
                alert("Произошла непредвиденная ошибка при выполнении запроса к серверу.")
            },
            success: function(res) {

                if (!res.result.success) {

                    if (!$jsMultiImagesUploaderErrorCnt.hasClass("alert")) {
                        $jsMultiImagesUploaderErrorCnt.addClass("alert alert-danger").html("<ul></ul>");
                    }

                    $.each(res.result.errors, function(k, v) {
                        $jsMultiImagesUploaderErrorCnt.find("ul").append("<li>Ошибка загрузки файла <strong>" + res.uploaded_file.name + "</strong>: "  + v.message + "</li>");
                    });

                    if (i < files.length - 1) {
                        uploadFile(files, i+1);
                    } else {
                        return;
                    }
                }

                if (res.result.success) {
                    let nextImageIncrement = $("img.new-uploaded-image").length + 1;
                    let jsObjectPhoto = $("#jsObjectPhotos");

                    jsObjectPhoto.append("<img src=\"/" + res.file.directory + "150x150/" + res.file.filename + "?crop=1\" class=\"new-uploaded-image\" alt=\"Uploaded Image\">");
                    jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[directory]["+nextImageIncrement+"]\" value=\""+res.file.directory+"\">");
                    jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[filename]["+nextImageIncrement+"]\" value=\""+res.file.filename+"\">");
                    //jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[x1]["+nextImageIncrement+"]\" value=\""+parseInt(data.x)+"\">");
                    //jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[y1]["+nextImageIncrement+"]\" value=\""+parseInt(data.y)+"\">");
                    //jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[x2]["+nextImageIncrement+"]\" value=\""+parseInt(data.x+data.width)+"\">");
                    //jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[y2]["+nextImageIncrement+"]\" value=\""+parseInt(data.y + data.height)+"\">");
                    //jsObjectPhoto.append("<input type=\"hidden\" name=\"uploaded_image[ratio]["+nextImageIncrement+"]\" value=\""+res.ratio+"\">");

                    if (i < files.length - 1) {
                        uploadFile(files, i+1);
                    } else if (!$jsMultiImagesUploaderErrorCnt.hasClass("alert")) {
                        let modal = bootstrap.Modal.getInstance($jsMultiImagesUploaderModal[0]);
                        modal.hide();
                        $("#jsMultiImagesUploaderForm")[0].reset();
                    }
                }
            }
        });
    }
});