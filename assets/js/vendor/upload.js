function upload() {
    jQuery('#uploadButton').click(function(){
        jQuery('#uploadInput').trigger('click');
    });

    jQuery('#uploadInput').change(function() {
        let domResult = jQuery('.upload__result');
        let files = this.files;
        let filesLength = this.files.length;
        if (filesLength === 0) {
            return
        }
        if (filesLength === 1) {
            domResult.empty().append(
                '<p class="error">Máximo un fichero</p>'
            );
        }
    });
}
