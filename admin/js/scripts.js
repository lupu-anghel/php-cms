tinymce.init({
  selector: "textarea",  // change this value according to your HTML
  plugins: ["wordcount", "textcolor", "table", "preview", "print", "media", "lists", "link", "insertdatetime", "emoticons", "charmap", "autosave", "hr"],
  toolbar: "forecolor backcolor emoticons charmap restoredraft"
});

$(document).ready(function(){

	$('#selectAllBoxes').click(function(event){

		if(this.checked) {

			$('.checkBoxes').each(function(){

				this.checked = true;

			}); 

		} else {

			$('.checkBoxes').each(function(){

				this.checked = false;

			}); 

		}

	});


});