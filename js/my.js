window.onload = function(){
	
	var form = document.querySelector('#contact');
	var file = form.querySelector('#file');

	

	addEventListener('submit', function(e){
		
		var message = document.querySelector('.message');
		if (!validata_file(file, ['png', 'jpg'])) {
			e.preventDefault();
			message.classList.add('active');

			return false;
		}

		message.classList.remove('active');
		

	});
	
	

}

function validata_file(file, extension){

	if(file.type == 'file'){
		var file_name = file.value;
	}

	var split_name = file_name.split('.');
	var file_ext = split_name[split_name.length-1];
	var length_ext = extension.length;

	for(var i = 0; i < length_ext; i++){
		if(file_ext === extension[i]){
			return true;
		}
	}
	
	
	return false;
}