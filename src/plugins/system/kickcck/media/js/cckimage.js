function deleteImage(context, id,filename, object) {
	var r = confirm("Wollen Sie wirklich das Bild löschen?");
	if (r == true) {
		jQuery.ajax({
			method: "POST",
			url: "index.php",
			data: {context: context, id: id, filename: filename}
		})
			.done(function( msg ) {
				alert( "Bilder gelöscht: " + msg );
				jQuery('#'+object+'nnimage').attr('src','');
			});
	}
}