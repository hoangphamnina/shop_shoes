/* Validation form */
function validateForm(ele) {
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName(ele);
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });

        $('.' + ele).find('input[type=submit],button[type=submit]').removeAttr('disabled');
    });
}

/* Validation form chung */
validateForm('validation-form');

/* HoldOn */
function holdonOpen(
    theme = 'sk-circle',
    text = 'Loading...',
    backgroundColor = 'rgba(0,0,0,0.8)',
    textColor = 'white'
) {
    var options = {
        theme: theme,
        message: text,
        backgroundColor: backgroundColor,
        textColor: textColor
    };

    HoldOn.open(options);
}
function holdonClose() {
    HoldOn.close();
}
/* Notify */
function notifyDialog(content = '', title = 'Thông báo', icon = 'fas fa-exclamation-triangle', type = 'blue') {
    $.alert({
        title: title,
        icon: icon, // font awesome
        type: type, // red, green, orange, blue, purple, dark
        content: content, // html, text
        backgroundDismiss: true,
        animationSpeed: 600,
        animation: 'zoom',
        closeAnimation: 'scale',
        typeAnimated: true,
        animateFromElement: false,
        autoClose: 'accept|3000',
        escapeKey: 'accept',
        buttons: {
            accept: {
                text: '<i class="fas fa-check align-middle mr-2"></i>Đồng ý',
                btnClass: 'btn-blue btn-sm bg-gradient-primary'
            }
        }
    });
}

/* Slug */
function slugConvert(slug, focus = false) {
    slug = slug.toLowerCase();
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, '-');
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');

    if (!focus) {
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    }

    return slug;
}
function slugPreview(title, focus = false) {
    var slug = slugConvert(title, focus);

    $('#slug').val(slug);
    $('#slugurlpreview' + ' strong').html(slug);
}
function slugPress() {
    var inputArticle = $('input.for-seo');
    var id = $('.slug-id').val();

    inputArticle.each(function (index) {
        var name = $(this).attr('id');
        if ($('#' + name).length) {
            $('body').on('keyup', '#' + name, function (e) {
                var keyCode = e.keyCode || e.which;
                var title = $('#' + name).val();

                if (keyCode != 13) {
                    if ((!id || $('#slugchange').prop('checked'))) {
                        /* Slug preivew */
                        slugPreview(title);
                    }

                    /* slug Alert */
                    slugAlert(2);
                }
            });
        }

        if ($('#slug').length) {
            $('body').on('keyup', '#slug', function (e) {
                var keyCode = e.keyCode || e.which;
                var title = $('#slug').val();

                if (keyCode != 13) {
                    /* Slug preivew */
                    slugPreview(title, true);

                    /* slug Alert */
                    slugAlert(2);
                }
            });
        }
    });
}
function slugChange(obj) {
    if (obj.is(':checked')) {
        /* Load slug theo tiêu đề mới */
        slugStatus(1);
        $('.slug-input').attr('readonly', true);
    } else {
        /* Load slug theo tiêu đề cũ */
        slugStatus(0);
        $('.slug-input').attr('readonly', false);
    }
}
function slugStatus(status) {
    var inputArticle = $('.card-article input.for-seo');

    inputArticle.each(function (index) {
        var name = $(this).attr('id');
        var title = '';
        if (status == 1) {
            if ($('#' + name).length) {
                title = $('#' + name).val();

                /* Slug preivew */
                slugPreview(title);
            }
        } else if (status == 0) {
            if ($('#slug-default').length) {
                title = $('#slug-default').val();

                /* Slug preivew */
                slugPreview(title);
            }
        }
    });
}
function slugAlert(result) {
    if (result == 1) {
        $('#alert-slug-danger').addClass('d-none');
        $('#alert-slug-success').removeClass('d-none');
    } else if (result == 0) {
        $('#alert-slug-danger').removeClass('d-none');
        $('#alert-slug-success').addClass('d-none');
    } else if (result == 2) {
        $('#alert-slug-danger').addClass('d-none');
        $('#alert-slug-success').addClass('d-none');
    }
}
function slugCheck() {
    var slugInput = $('.slug-input');
    var id = $('.slug-id').val();

    slugInput.each(function (index) {
        var slugId = $(this).attr('id');
        var slug = $(this).val();
        if (slug) {
            $.ajax({
                url: 'api/slug.php',
                type: 'POST',
                dataType: 'html',
                async: false,
                data: {
                    slug: slug,
                    id: id,
                },
                success: function (result) {
                    slugAlert(result);
                }
            });
        }
    });
}

/* Reader image */
function readImage(inputFile, elementPhoto) {
    if (inputFile[0].files[0]) {
        if (inputFile[0].files[0].name.match(/.(jpg|jpeg|png|gif|svg)$/i)) {
            var size = parseInt(inputFile[0].files[0].size) / 1024;

            if (size <= 4096) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(elementPhoto).attr('src', e.target.result);
                };
                reader.readAsDataURL(inputFile[0].files[0]);
            } else {
                notifyDialog('Dung lượng hình ảnh lớn. Dung lượng cho phép <= 4MB ~ 4096KB');
                return false;
            }
        } else {
            $(elementPhoto).attr('src', '');
            notifyDialog('Định dạng hình ảnh không hợp lệ');
            return false;
        }
    } else {
        $(elementPhoto).attr('src', '');
        return false;
    }
}

/* Photo zone */
function photoZone(eDrag, iDrag, eLoad) {
    if ($(eDrag).length) {
        /* Drag over */
        $(eDrag).on('dragover', function () {
            $(this).addClass('drag-over');
            return false;
        });

        /* Drag leave */
        $(eDrag).on('dragleave', function () {
            $(this).removeClass('drag-over');
            return false;
        });

        /* Drop */
        $(eDrag).on('drop', function (e) {
            e.preventDefault();
            $(this).removeClass('drag-over');

            var lengthZone = e.originalEvent.dataTransfer.files.length;

            if (lengthZone == 1) {
                $(iDrag).prop('files', e.originalEvent.dataTransfer.files);
                readImage($(iDrag), eLoad);
            } else if (lengthZone > 1) {
                notifyDialog('Bạn chỉ được chọn 1 hình ảnh để upload');
                return false;
            } else {
                notifyDialog('Dữ liệu không hợp lệ');
                return false;
            }
        });

        /* File zone */
        $(iDrag).change(function () {
            readImage($(this), eLoad);
        });
    }
}

function onSearch(obj, url) {
    if (url == '') {
        notifyDialog('Đường dẫn không hợp lệ');
        return false;
    } else {
        var keyword = $('#' + obj).val();
        url = filterCategory(url);

        if (keyword) {
            url += '&keyword=' + encodeURI(keyword);
        }

        window.location = filterCategory(url);
    }
}

/* onChange Category */
function filterCategory(url) {
    if ($('.filter-category').length > 0 && url != '') {
        var id = '';
        var value = 0;

        $('.filter-category').each(function () {
            id = $(this).attr('id');
            if (id) {
                value = parseInt($('#' + id).val());
                if (value) {
                    url += '&' + id + '=' + value;
                }
            }
        });
    }

    return url;
}

function onchangeCategory(obj) {
    var name = '';
    var keyword = $('#keyword').val();
    var url = LINK_FILTER;

    obj.parents('.form-group').nextAll().each(function () {
        name = $(this).find('.filter-category').attr('name');
        if ($(this) != obj) {
            $(this).find('.filter-category').val(0);
        }
    });

    url = filterCategory(url);

    if (keyword) {
        url += '&keyword=' + encodeURI(keyword);
    }

    return (window.location = url);
}

$(document).ready(function () {
    /* Loader */
    if ($('.loader-wrapper').length) {
        setTimeout(function () {
            $('.loader-wrapper').fadeOut('medium');
        }, 300);
    }
    /* Slug */
    slugPress();
    if ($('#slugchange').length) {
        $('body').on('click', '#slugchange', function () {
            slugChange($(this));
        });
    }
    /* PhotoZone */
    if ($('#photo-zone').length) {
        photoZone('#photo-zone', '#file-zone', '#photoUpload-preview img');
    }
    /* Format price */
    if ($('.format-price').length) {
        $('.format-price').priceFormat({
            limit: 13,
            prefix: '',
            centsLimit: 0
        });
    }
    /* Format price */
    if ($('.format-price').length) {
        $('.format-price').priceFormat({
            limit: 13,
            prefix: '',
            centsLimit: 0
        });
    }
    /* Check required form */
    if ($('.submit-check').length) {
        $('.submit-check').click(function () {
            var formCheck = $(this).parents('form.validation-form');

            /* Holdon */
            holdonOpen();

            /* Check slug */
            slugCheck();

            /* Elements */
            var flag = true;
            var slugs = '';
            var slugOffset = $('.card-slug');
            var slugsInValid = $('.card-slug :required:invalid');
            var slugsError = $('.card-slug .text-danger').not('.d-none');
            var cardOffset = 0;
            var elementsInValid = $('.card :required:invalid');

            /* Check if has slug vs name */
            if (slugsInValid.length || slugsError.length) {
                flag = false;
                slugs = slugsError.length ? slugsError : slugsInValid;

                /* Scroll to error */
                setTimeout(function () {
                    $('html,body').animate({ scrollTop: slugOffset.offset().top - 40 }, 'medium');
                }, 500);
            } else if (elementsInValid.length) {
                flag = false;

                /* Scroll to error */
                if (cardOffset) {
                    setTimeout(function () {
                        $('html,body').animate({ scrollTop: cardOffset.offset().top - 100 }, 'medium');
                    }, 500);
                }
            }

            /* Holdon close */
            holdonClose();

            /* Check form validated */
            if (!flag) {
                formCheck.addClass('was-validated');
            } else {
                formCheck.removeClass('was-validated');
            }

            return flag;
        });
    }
    /* Check all */
    if ($('#selectall-checkbox').length) {
        $('body').on('click', '#selectall-checkbox', function () {
            var parentTable = $(this).parents('table');
            var input = parentTable.find('input.select-checkbox');

            if ($(this).is(':checked')) {
                input.each(function () {
                    $(this).prop('checked', true);
                });
            } else {
                input.each(function () {
                    $(this).prop('checked', false);
                });
            }
        });
    }
    /* Change status ajax */
    if ($('.show-checkbox').length) {
        $('body').on('click', '.show-checkbox', function () {
            var id = $(this).attr('data-id');
            var table = $(this).attr('data-table');
            var attr = $(this).attr('data-attr');
            var $this = $(this);

            $.ajax({
                url: 'api/status.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    id: id,
                    table: table,
                    attr: attr
                },
                success: function () {
                    if ($this.is(':checked')) $this.prop('checked', false);
                    else $this.prop('checked', true);
                }
            });

            return false;
        });
    }
    /* Change numb jax */
    if ($('input.update-numb').length) {
        $('body').on('change', 'input.update-numb', function () {
            var id = $(this).attr('data-id');
            var table = $(this).attr('data-table');
            var value = $(this).val();

            $.ajax({
                url: 'api/numb.php',
                type: 'POST',
                dataType: 'html',
                data: {
                    id: id,
                    table: table,
                    value: value
                }
            });

            return false;
        });
    }
});