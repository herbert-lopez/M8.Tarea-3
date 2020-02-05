<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password</title>
</head>
<body>

	<form>
		Contraseñas:<br>
		<textarea name="txtPass" id="txtPass" rows="25" cols="120"></textarea>
		<br>
		<button type="button" id="Btn1" onclick="Unhash();">Unhash</button>
		<meta name="csrf-token" content="{{ csrf_token() }}">
	</form>
	<textarea name="txtResultado" id="txtResultado" rows="25" cols="120"></textarea>

	<form>
		<br>
		<button type="button" id="Btn2" onclick="FormatoSHA256();" disabled="true">SHA256</button>
		<br>
		Nuevo formato:<br>
		<textarea name="txtSHA" id="txtSHA" rows="25" cols="120"></textarea>
		<meta name="csrf-token2" content="{{ csrf_token() }}">
	</form>
</body>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script type="text/javascript">

	function Unhash(){
		var urlHash='{{ url('/BuscarPass') }}';
		var Arraytexto = new Array();
		var texto;
		var plaintext;
		var ClearText='';
		texto=$('#txtPass').val();
		Arraytexto=texto.split(' ');
		var query = '';
		var conteo = 0;

		for (var i = 0; i <= Arraytexto.length-1; i++) {

			if(i==Arraytexto.length-1){
				query=query+Arraytexto[i];
			}else{
				query=query+Arraytexto[i]+',';
			}
				
			if(conteo==99 || conteo==Arraytexto.length-1){
//				console.log("entro.."+conteo);
				$.ajax({
					headers: {
        					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    					},
					 data:  {
			           	'query':query,
			           },
				    url:   urlHash,
				    type:  'post',
				    success: function (data) {
				    	var texto = JSON.parse(data);
				    	//console.log(texto.status);

				    	if(texto.status=='error'){
				    		$('#txtResultado').val(texto.status+': '+texto.errorMessage);
				    	}

				    	else{
				    		//console.log(texto.result);
				    		for(x in texto.result){
				    			//console.log(texto.result[x]);
				    			if(texto.result[x]==null){
				    				ClearText=ClearText+'\n';	
				    			}
				    			else{
				    				ClearText=ClearText+'\n'+texto.result[x].plain;
				    			}
				    		}

				    		$('#txtResultado').val(ClearText);
				    		$('#Btn2').attr("disabled", false);

				    	}
				    }

				});

			}
			else{

			}
			conteo++;
		}

	}//Fin Unhash


	function FormatoSHA256(){
		var urlSHA256='{{ url('/SHA256Encrypt') }}';
		var plaintext=$('#txtResultado').val();
		var ArrayPlainText = new Array();
		var ArraySHA256 = new Array();
		var TextoEncriptado='';
		ArrayPlainText=plaintext.split('\n');
		var query='';

		for (var i = 0; i <= ArrayPlainText.length-1; i++) {

			if(i==ArrayPlainText.length-1){
				query=query+ArrayPlainText[i];
			}else{
				query=query+ArrayPlainText[i]+',';
			}
			//console.log(ArrayPlainText[i]);
		}

		$.ajax({
				headers: {
    					'X-CSRF-TOKEN': $('meta[name="csrf-token2"]').attr('content')
					},
				 data:  {
		           	'query':query,
		           },
			    url:   urlSHA256,
			    type:  'post',
			    success: function (data) {
			    	var SHA256Text = data;
			    	ArraySHA256=SHA256Text.split(',');

			    	for (var i = 0; i <= ArraySHA256.length-1; i++) {
						if(i==ArraySHA256.length-1){
							TextoEncriptado=TextoEncriptado+ArraySHA256[i];
						}else{
							TextoEncriptado=TextoEncriptado+ArraySHA256[i]+'\n';
						}
					}

					$('#txtSHA').val(TextoEncriptado);
			    }

			});

		//console.log(query);
	}


</script>



</html>