$(document).ready(function () {

    $('.area-files').bind('dragover',function () {
        $(this).addClass('area-drag-file');
        return false;
    });

    $('.area-files').bind('dragleave', function () {
        $(this).removeClass('area-drag-file');
        return false;
    });

    $('.area-files').on('drop', function (e) {
        e.preventDefault();
        $(this).removeClass('area-drag-file');

        var formData = new FormData();
        var files_list = e.originalEvent.dataTransfer.files;
        for (let i = 0; i < files_list.length; i++) {
            formData.append('file[]', files_list[i]);
        }

        uploadFiles(formData);
    });

    $('input[type="file"]').on('change', function (e) {
        var formData = new FormData();
        $.each($(this)[0].files, function (key, input) {
            formData.append('file[]', input);
        });

        uploadFiles(formData);
    });

    function uploadFiles(formData) {

        $.ajax({
            url: "/php/uploadFiles.php",
            method: "POST",
            dataType: 'json',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success(data) {
                if (data.status == true) {
                    $('.uploaded-files').append(data.files);
                } else {
                    alert(data.message);
                }
            }
        })
    }

});

$(document).on('click', '.btn-close', function () {
    //alert(this.parentNode);
    this.parentNode.remove();
});