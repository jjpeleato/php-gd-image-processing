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
 * Form events
 */
function uploadActions() {
    let domResult = jQuery('.upload__result');

    jQuery('#uploadReset').click(function () {
        jQuery('#uploadButton').show();
        jQuery('#uploadReset').hide();
        jQuery('#uploadSubmit').hide();
        domResult.empty();
    });

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

    jQuery('#uploadForm').submit(function (e) {
        e.preventDefault(); //prevent default action

        let url = jQuery(this).attr("action"); // get form action url
        let myRequestURL = url + '/?timestamp=' + new Date().getTime();
        let method = jQuery(this).attr("method"); // get form GET/POST method
        let formData = new FormData(jQuery(this)[0]); // Encode form elements for submission

        jQuery.ajax({
            type: method,
            url: myRequestURL,
            data: formData,
            dataType: 'json',
            crossDomain: true,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                domResult.empty().append('<p class="warning">Starting process</p>');
            },
            success: function (result, status, xhr) {
                let respond = result.respond;
                let html = '<p class="success">'+respond+'</p>';

                let data = result.data;
                if (data.length > 0) {
                    html += '<ul>';
                    jQuery.each(data, function(index, value) {
                        html += '<li>';
                        html += '<a href="/upload/' + value + '" target="_blank">' + value + '</a>';
                        html += '</li>';
                    });
                    html += '</ul>';
                }

                domResult.empty().append(html);
            },
            error: function (xhr, status, error) {
                let respond = xhr.responseJSON.respond;
                domResult.empty().append('<p class="error">'+respond+'</p>');
            },
            xhr: function () {
                let xhr = jQuery.ajaxSettings.xhr();

                xhr.upload.onprogress = function (evt) {
                    let percent = parseInt(evt.loaded / evt.total * 100);
                    domResult.empty().append('<p class="warning">' + percent + ' %</p>');
                };
                xhr.upload.onload = function () {
                    domResult.empty().append('<p class="warning">100 %</p>');
                };

                return xhr;
            }
        });

        return false;
    });
}
