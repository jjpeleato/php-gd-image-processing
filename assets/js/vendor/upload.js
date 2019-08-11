/**
 * Validate allowed files
 *
 * @param str
 * @returns {boolean}
 */
function allowedFiles(str) {
    if (str === null || str.length === 0){
        return false;
    }

    let allowed = ['.png', '.jpeg', '.jpg'];
    let ext = (str.substring(str.lastIndexOf("."))).toLowerCase();
    let search = allowed.indexOf(ext);

    return search !== -1;
}

/**
 * Print humanized size files
 *
 * @param size
 * @returns {string}
 */
function sizeFiles(size) {
    let fExt = ['Bytes', 'KB', 'MB', 'GB'];
    let i = 0;

    while (size >= 1024) {
        size = size / 1024;
        i++;
    }

    size = Math.round(size * 100) / 100;
    return size + ' ' + fExt[i];
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
    let domResult = jQuery('.upload__result');

    jQuery('#uploadButton').click(function () {
        jQuery('#uploadInput').trigger('click');
    });

    jQuery('#uploadInput').change(function () {
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
        if (!allowedFiles(files[0].name)) {
            domResult.empty().append(
                '<p class="error">' + filesLength + ' files selected.</p>'
            ).append(
                '<p class="error">File not allowed. Only .png, .jpeg and .jpg file.</p>'
            ).append(
                '<p class="error"><i class="fas fa-file"></i> ' + files[0].name +
                ' (' + sizeFiles(files[0].size) + ')</p>'
            );
            return;
        }

        jQuery('#uploadButton').hide();
        jQuery('#uploadReset').show();
        jQuery('#uploadSubmit').show();
        domResult.empty().append(
            '<p class="warning">' + filesLength + ' files selected</p>'
        ).append(
            '<p class="warning"><i class="fas fa-file"></i> ' + files[0].name +
            ' (' + sizeFiles(files[0].size) + ')</p>'
        );
    });

    jQuery('#uploadReset').click(function () {
        jQuery('#uploadButton').show();
        jQuery('#uploadReset').hide();
        jQuery('#uploadSubmit').hide();
        domResult.empty();
    });

    jQuery('#uploadSubmit').click(function () {
        let form = jQuery('#uploadForm');
        let formData = new FormData(form);
        upload(formData, domResult);

        return false;
    });
}
