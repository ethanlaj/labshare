<?PHP // Credit: Rajesh Kumar Sahanee on https://zatackcoder.com/upload-file-to-google-cloud-storage-using-php/ 
?>

<html>

<head>
	<meta charset="UTF-8">
	<title>GCP Storage File Upload using PHP</title>
</head>

<body>
	<form id="fileUploadForm" method="post" enctype="multipart/form-data">
		<input type="file" name="file" />
		<input type="submit" name="upload" value="Upload" />
		<span id="uploadingmsg"></span>
		<hr />
		<strong>Response (JSON)</strong>
		<pre id="json">json response will be shown here</pre>

		<hr />
		<strong>Public Link</strong> <span>(https://storage.googleapis.com/[BUCKET_NAME]/[OBJECT_NAME])</span><br />
		<b>Note:</b> we can use this link only if object or the whole bucket has made public, which in our case has already made bucket public<br />
		<div id="output"></div>
	</form>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script>
		$("#fileUploadForm").submit(function(e) {
			e.preventDefault();
			var action = "requests.php?action=upload";
			$("#uploadingmsg").html("Uploading...");
			var data = new FormData(e.target);
			$.ajax({
				type: 'POST',
				url: action,
				data: data,
				/*THIS MUST BE DONE FOR FILE UPLOADING*/
				contentType: false,
				processData: false,
			}).done(function(response) {
				$("#uploadingmsg").html("");
				$("#json").html(JSON.stringify(response, null, 4));
				//https://storage.googleapis.com/[BUCKET_NAME]/[OBJECT_NAME]
				$("#output").html('<a href="https://storage.googleapis.com/' + response.data.bucket + '/' + response.data.name + '"><i>https://storage.googleapis.com/' + response.data.bucket + '/' + response.data.name + '</i></a>');
				if (response.data.contentType === 'image/jpeg' || response.data.contentType === 'image/jpg' || response.data.contentType === 'image/png') {
					$("#output").append('<br/><img src="https://storage.googleapis.com/' + response.data.bucket + '/' + response.data.name + '"/>');
				}
			}).fail(function(data) {
				//any message
			});
		});
	</script>
</body>

</html>