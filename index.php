<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Subir Archivo</title>
	<script src="js/jquery-1.9.1.js"></script>
</head>
<body>
	<center>
		<h3>Upload File Ajax</h3>

	    <input id="upload_file" type="file" onchange="readSize()"/>
	    <button onclick="uploadExecute()">Subir Archivo</button>

		<br>
		Progress: <progress value="0"></progress>
		<br>

		<div id="results"></div>
		
	</center>

	<script>

		var file, formData;
		function readSize(){
			file = document.getElementById("upload_file").files[0];
			//Preparamos el paquete a enviar
			formData = new FormData();
            formData.append("uploaded_file",file);
            formData.append("enctype",'multipart/form-data');

		    if (file.size > 1024) {
		        console.log('Tamaño maximo permitido es de 2K');
		    }
		}
		function uploadExecute(){
			

		    $.ajax({
		        // Dirección del archivo a ejecutar en el servidor
		        url: 'upload_file.php',
		        type: 'POST',
		        
		        data: formData, //adjuntamos el paquete

		        cache: false,
		        contentType: false,
		        processData: false,

		        // Configuración Personalizada XMLHttpRequest
		        xhr: function() {
		            var myXhr = $.ajaxSettings.xhr();
		            if (myXhr.upload) {
		                // Obtenemos Progresivamente el nivel de carga del archivo
		                myXhr.upload.addEventListener('progress', function(e) {
		                    if (e.lengthComputable) {
		                    	//Actualizamos la etiqueta PROGRESS segun su nivel de carga del archivo
		                        $('progress').attr({
		                            value: e.loaded,
		                            max: e.total,
		                        });
		                    }
		                } , false);
		            }
		            return myXhr;
		        }
		        ,success: function(data, status, xhr) {
		        	//Imprimimos Resultados del archivo "upload_file.php" desde el servidor
				    $("#results").html(data);
				}
		    }).done(function() {
		    	//Mensaje que indica que se a finalizado
			    console.log("Upload finished.");
			});
		}
	</script>
</body>
</html>