// Gus Example JS

$(document).ready(function() {
	
	$('#kickstarter-btn').click(function() {
		
		$j.modal.display({
			title: 'Supported by JiveJS, the less is more UI',
			html: $('<a style="display:block;padding:1%;" href="https://github.com/maxatbrs/JiveJS/wiki/Getting-Started" target="_blank"/>').text('Get Started!'),
			width:200,
			height:200
		});
		
	})
	
});