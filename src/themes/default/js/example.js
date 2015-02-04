// Gus Example JS



$(document).ready(function() {

    $('.block').attr("draggable",true);

    $('.block-template').hide();

	$('.block').on('dragstart', function(evt) {

		var eventData = evt.originalEvent.dataTransfer;

		eventData.setData("block", $(evt.target).data("block"));

	});

	$('.block-target').on('dragover', function(ev) {

    	 ev.preventDefault();

	});

	$('.block-target').on('drop', function(ev) {

    	ev.preventDefault();

    	var blockName = ev.originalEvent.dataTransfer.getData("block");

        if(blockName == "youtube") {

            var embed = prompt("Youtube ID","rp7B7GRWCIg");
            
            if(embed) {

                $(".block-template.youtube iframe").attr("src", "//www.youtube.com/embed/"+embed);
            }

        }

    	var newNode = $(".block-template."+blockName).clone().removeClass("block-template").show();
    	
   	 	$(ev.target).append(newNode);

	});

	
});