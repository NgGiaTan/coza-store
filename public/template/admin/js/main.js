$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function removeRow(id, url) {
    if (confirm('Are you sure you want to remove?')) {
        $.ajax({
            type: 'DELETE',
            datatype: 'json',
            data: { id },
            url: url,
            success: function(result) {
                console.log('Server response:', result); // Log phản hồi từ server
                if (result.error === false) {
                    alert(result.message);
                    $('#row-' + id).remove(); // Xóa hàng khỏi DOM
                } else {
                    alert('Lỗi khi xóa sản phẩm!!');

                }
            },
            error: function(xhr) {
                // Xử lý lỗi nếu có
                alert('Có lỗi xảy ra: ' + xhr.responseText);
            }
        });
    }
}

//upload file
$('#upload').change(function () {
    const form = new FormData();
    form.append('file', $(this)[0].files[0]);

    $.ajax({
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'JSON',
        data: form,
        url: '/admin/upload/services',
        success: function (results){
            if(results.error === false){
                $('#image_show').html('<a href="' + results.url + '" target="_blank">' +
                    '<img src="' + results.url + '" width="100px"></a>');
                
                $('#thumb').val(results.url);
            }else{
                alert('Upload file error');
            }
        }

    });
});