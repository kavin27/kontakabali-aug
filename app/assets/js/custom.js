$(function () {
	var inputFile = $('input[name=file]');
	var uploadURI = $('#form-upload').attr('action');

	$('#upload-btn').on('click', function(event) {
		var fileToUpload = inputFile[0].files[0];
		// make sure there is file to upload
		if (fileToUpload != 'undefined') {
			// provide the form data
			// that would be sent to sever through ajax
			var formData = new FormData();
			formData.append("file", fileToUpload);

			// now upload the file using $.ajax
			$.ajax({
				url: uploadURI,
				type: 'post',
				data: formData,
				processData: false,
				contentType: false,
				success: function() {
					listFilesOnServer();
				}
			});
		}
	});

	function listFilesOnServer () {
		var items = [];

		$.getJSON(uploadURI, function(data) {
			$.each(data, function(index, element) {
				items.push('<li class="list-group-item">' + element  + '<div class="pull-right"><a href="#"><i class="glyphicon glyphicon-remove"></i></a></div></li>');
			});
			$('.list-group').html("").html(items.join(""));
		});
	}
});