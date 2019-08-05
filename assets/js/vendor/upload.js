/**
 * Clean form
 */
function cleaner() {

}

/**
 * Upload file and send to endpoint
 *
 * @param data
 * @param dom
 */
function upload(data, dom) {
    var myRequestURL = '/src?timestamp=' + new Date().getTime();

    jQuery.ajax({
        type: 'POST',
        url: myRequestURL,
        data: data,
        dataType: 'json',
        crossDomain: true,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            dom.empty().append(
                '<p class="warning">Starting process</p>'
            );
        },
        success: function (result, status, xhr) {
            let code = parseInt(result.status.code, 10);
            let message = result.message;

            switch (code) {
                case 400:
                    dom.empty().append(
                        '<p class="error">' + message + '</p>'
                    );
                    break;
                case 200:
                    dom.empty().append(
                        '<p class="success">' + message + '</p>'
                    );
                    break;
            }

        },
        error: function (xhr, status, error) {
            console.log('error', xhr, status, error);
            dom.empty().append(
                '<p class="error">' + percent + ' %</p>'
            );
        },
        xhr: function () {
            let xhr = jQuery.ajaxSettings.xhr();

            xhr.upload.onprogress = function (evt) {
                let percent = parseInt(evt.loaded / evt.total * 100);
                dom.empty().append(
                    '<p class="warning">' + percent + ' %</p>'
                );
            };
            xhr.upload.onload = function () {
                dom.empty().append(
                    '<p class="warning">100 %</p>'
                );
            };

            return xhr;
        }
    });
}

/**
 * Form events
 */
function uploadActions() {
    jQuery('#uploadButton').click(function () {
        jQuery('#uploadInput').trigger('click');
    });

    jQuery('#uploadInput').change(function () {
        let domResult = jQuery('.upload__result');
        let files = this.files;
        let filesLength = this.files.length;
        if (filesLength === 0) {
            return;
        }
        if (filesLength > 1) {
            domResult.empty().append(
                '<p class="error">Oh! Only one file is allowed at most</p>'
            );
            return;
        }

        jQuery('#uploadButton').hide();
        jQuery('#uploadReset').show();
        jQuery('#uploadSubmit').show();

        let form = jQuery('#uploadForm');
        //let formData = new FormData(form);
        //upload(formData, domResult);
    });
}
