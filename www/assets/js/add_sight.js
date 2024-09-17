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

                    jsObjectPhoto.append("<div style=\"position: relative\"><img src=\"/" + res.file.directory + "150x150/" + res.file.filename + "?crop=1\" class=\"new-uploaded-image\" alt=\"Uploaded Image\"><a class=\"jsEditObjectRemoveTmpImage\" style=\"position: absolute; top: -10px; right: -10px;\" href=\"#\" data-image-id=\"<?php print $image->getSightImageId()?>\"><svg width=\"32\" height=\"32\" viewBox=\"0 0 32 32\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
                        "                                        <path d=\"M16 3C13.4288 3 10.9154 3.76244 8.77759 5.1909C6.63975 6.61935 4.97351 8.64968 3.98957 11.0251C3.00563 13.4006 2.74819 16.0144 3.2498 18.5362C3.75141 21.0579 4.98953 23.3743 6.80762 25.1924C8.6257 27.0105 10.9421 28.2486 13.4638 28.7502C15.9856 29.2518 18.5995 28.9944 20.9749 28.0104C23.3503 27.0265 25.3807 25.3603 26.8091 23.2224C28.2376 21.0846 29 18.5712 29 16C28.996 12.5534 27.6251 9.24912 25.188 6.81201C22.7509 4.3749 19.4466 3.00398 16 3ZM20.707 19.293C20.8 19.3858 20.8739 19.496 20.9242 19.6174C20.9746 19.7387 21.0006 19.8688 21.0007 20.0002C21.0007 20.1316 20.9749 20.2617 20.9246 20.3832C20.8744 20.5046 20.8007 20.6149 20.7078 20.7078C20.6149 20.8007 20.5046 20.8744 20.3832 20.9246C20.2617 20.9749 20.1316 21.0007 20.0002 21.0006C19.8688 21.0006 19.7387 20.9746 19.6174 20.9242C19.496 20.8738 19.3858 20.8 19.293 20.707L16 17.4141L12.707 20.707C12.5195 20.8942 12.2652 20.9993 12.0002 20.9991C11.7352 20.999 11.4811 20.8937 11.2937 20.7063C11.1063 20.5189 11.001 20.2648 11.0009 19.9998C11.0007 19.7348 11.1058 19.4806 11.293 19.293L14.5859 16L11.293 12.707C11.1058 12.5194 11.0007 12.2652 11.0009 12.0002C11.001 11.7352 11.1063 11.4811 11.2937 11.2937C11.4811 11.1063 11.7352 11.001 12.0002 11.0009C12.2652 11.0007 12.5195 11.1058 12.707 11.293L16 14.5859L19.293 11.293C19.4806 11.1058 19.7348 11.0007 19.9998 11.0009C20.2648 11.001 20.5189 11.1063 20.7063 11.2937C20.8937 11.4811 20.999 11.7352 20.9991 12.0002C20.9993 12.2652 20.8942 12.5194 20.707 12.707L17.4141 16L20.707 19.293Z\" fill=\"black\"/>\n" +
                        "                                    </svg></a></div>");
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

    $("a[data-image-id]").click(function(e) {
        e.preventDefault();

        if (!confirm("Данная фотография будет полностью удалена из системы без возможности восстановления, продолжить?")) {
            return;
        }

        const image_id = $(this).attr("data-image-id");
        const sight_id = $(this).attr("data-sight-id");

        const $relative_div = $(this).closest("div");

        $.ajax({
            url: "/Sights/" + sight_id + "/Edit/" + image_id + "/PurgeImage",
            method: "GET",
            success: function(res) {
                if (res.result?.success) {
                    $relative_div.fadeOut();
                } else {
                    alert(res.result?.errors_as_string);
                }
            },
            error: function(err) {
                alert("Произошла непредвиденная ошибка при выполнении запроса к серверу хранения данных. Пожалуйста, проверьте наличие интернета и попробуйте еще раз");
            }
        })
    });

    $(document).on("click", ".jsEditObjectRemoveTmpImage", function(e) {
        e.preventDefault();

        if (!confirm('Вы уверены что хотите удалить только что загруженное изображение?')) {
            return;
        }

        let $div = $(this).closest("div");
        let $img = $div.find("img");
        let path = $img.attr("src");

        $.ajax({
            url: "/Images/RemoveJustUploaded",
            method: "POST",
            data: {"path": path},
            dataType: "json",
            cache: false,
            success: function(res) {
                if (res.result.success) {
                    $div.fadeOut();
                } else {
                    alert(res.result.errors_as_string)
                }
            },
            error: function() {
                alert("Произошла непредвиденная ошибка при выполнении запроса к серверу")
            }
        })
    });
});