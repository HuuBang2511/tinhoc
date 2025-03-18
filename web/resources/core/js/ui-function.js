$(document).ready(function () {
    uiUpdate();
    uiEventUpdate();
});
function reloadTable(selector, url) {
    $.ajax({
        url: url,
        type: "GET",
        dataType: "html",
        success: function (data) {
            $(selector).empty().append(data);
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        },
        complete: function (xhr, status) {
            //$('#showresults').slideDown('slow')
        }
    })
}
function formatMoney(num) {
    //console.log(num);
    var p = num.toFixed(2).split(".");
    return p[0].split("").reverse().reduce(function (acc, num, i, orig) {
        return num == "-" ? acc : num + (i && !(i % 3) ? "." : "") + acc;
    }, "");
}

function uiEventUpdate(parent_id) {
    parent_id = typeof (parent_id) === 'undefined' ? '' : parent_id;
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    $(parent_id + " .custom-add-more").on('click', function (e) {

        // Disable default
        e.preventDefault();
        // Get select for this
        var _this = $(this);
        // Get required attribute
        var parent = $(_this.attr('data-parent'));
        var itemname = _this.attr('data-item');
        var item = $(itemname);
        var initcounter = parent.children().length;
        var counter = typeof (item.attr('data-counter')) === 'undefined' ? initcounter : item.attr('data-counter');
        var removeButton = "<button class='display-none btn btn-danger btn-circle' id='btn_remove_add' style='position: absolute'>x</button>";

        var newitem = item.clone();
        var newitemid = newitem.attr('id') + counter

        newitem.attr('id', newitemid);

        parent.append(newitem);
        //Update name of all input
        $(itemname + counter + " input").each(function () {
            var _ts = $(this);
            _ts.attr('name', String.format(_ts.attr('name'), counter));
            _ts.attr('disabled', false);
        });

        $(itemname + counter + " select").each(function () {
            var _ts = $(this);
            _ts.attr('name', String.format(_ts.attr('name'), counter));
            _ts.attr('disabled', false);
        });

        // Check if remove button not exist
        if ($('#btn_remove_add').length === 0) {
            $(newitem.parent()).append(removeButton);
        }

        removeButton = $('#btn_remove_add');

        newitem.hover(function () {
            var posNewitem = newitem.position();

            removeButton.css('top', posNewitem.top);
            removeButton.css('left', posNewitem.left);

            removeButton.attr('data-ref-id', newitemid);
            removeButton.removeClass('display-none');
        });

        newitem.mouseleave(function () {
            if (!removeButton.is(':hover')) {
                removeButton.addClass('display-none');
            }
        })

        removeButton.on('click',function (e) {
            e.preventDefault();

            $('#' + removeButton.attr('data-ref-id')).remove();
            removeButton.addClass('display-none');

        });

        item.attr('data-counter', ++counter);

    });
    ///////////////////////////////////////////////////////
    $(".custom-search-datatable").on('click', function (e) {
        e.preventDefault();
        var _this = $(this);
        var form = $(_this.attr('data-form'));
        var table = $(_this.attr('data-table')).DataTable();
        var url = _this.attr('data-url');

        table.ajax.url(url + form.serialize());
        table.ajax.reload();
    });
    /////////////////////////////////////////////////////////
    $(parent_id + '.custom-submit-input').keydown(function (event) {
        if (event.keyCode == 13) {
            $($(this).attr('data-target')).click();
            return false;
        }
    });
    ////////////////////////////////////
    // data-target, data-submit, data-value
    $(parent_id + '.custom-click-bind-input').on('click', function (e) {
        var _this = $(this);
        var _target = $(_this.attr('data-target'));
        var _value = _this.attr('data-value');
        var _submit = _this.attr('data-submit');

        if (_target.val() !== _value) {
            _target.val(_value)
            $(_submit).click();
        }
    });
    //////////////////////////////////////
    /////////////////////////////////////
    $(parent_id + '.custom-click-bind-div').on('click', function (e) {
        var _this = $(this);
        var _target = $(_this.attr('data-div'));
        _target.text(' ' + _this.text());
    });
    //////////////////////////////////////
    // data-target, data-target-event, data-target-value, data-css
    $(parent_id + '.custom-base-on-other').each(function () {
        var _this = $(this);
        var target = _this.attr('data-target');
        var target_value = _this.attr('data-target-value');
        var target_event = _this.attr('data-target-event');
        var css = _this.attr('data-css');

        if ($(target).val() === target_value) {
            _this.addClass(css);
        } else {
            _this.removeClass(css);
        }

        $(target).on(target_event, function () {
            if ($(target).val() === target_value) {
                _this.addClass(css);
            } else {
                _this.removeClass(css);
            }
        });
    });

    ////////////////////////////////////////////
    //For toggle element
    $(parent_id + ' .custom-element-toggle').each(function () {
        var _this = $(this);
        var _event = _this.attr('data-event');
        var _prevent = _this.attr('data-prevent');
        var _toggleclass = _this.attr('data-toggle');
        var _target = _this.attr('data-target');

        _this.on(_event, function (e) {
            if (!checkUndefine(_prevent)) {
                e.preventDefault();
            }
            $(_target).toggleClass(_toggleclass);
        });
    });
    ///////////////////////////////////////////
    $(parent_id + ' .custom-element-load-ajax-div').each(function () {
        var _this = $(this);
        var _div = $(_this.attr('data-target-div'));
        _this.on('click', function () {

            $.ajax({
                url: _this.attr('data-url'),
                method: 'GET',
                success: function (html) {
                    _div.empty().append(html);
                    uiEventUpdate('#' + _div.parent('div').attr('id'));
                },
                error: function () {
                    _div.empty().append('' +
                        '<div class="col-lg-12 form-group">' +
                        '<h3 class="font-red">' +
                        '<i class="fa fa-exclamation"></i> Xảy ra lỗi đường truyền' +
                        '</h3><button class="pull-right" data-dismiss="modal"><span class="fa fa-times"></span></button>' +
                        '</div>' +
                        '<div style="clear: both"></div>');
                }
            });
        });
    });
    ////////////////////////////////////////////
    $(parent_id + ' .custom-div-ajax').each(function () {
        var _this = $(this);
        if (typeof(_this.attr('data-loaded')) === 'undefined') {
            $(_this.parent()).addClass('loading');
            $.ajax({
                url: _this.attr('data-url'),
                method: 'GET',
                async: true,
                success: function (html) {
                    _this.attr('data-loaded', true);
                    _this.empty().append(html);
                    uiEventUpdate('#' + _this.attr('id'));
                    $(_this.parent()).removeClass('loading');
                }
            });
        }
    });
    ////////////////////////////////////////////
    $(parent_id + ' .custom-replace-url').each(function () {
        var _this = $(this);
        _this.on('click', function () {
            if (_this.attr('data-replace') !== 'undefined') {
                window.history.pushState("object or string", "Title", _this.attr('data-url'));
            }
        });
    });
    ////////////////////////////////////////////
    $(parent_id + ' .custom-bind-value').each(function () {
        var _this = $(this);
        $(_this.attr('data-target')).empty().append(_this.val());
    });
    ////////////////////////////////////////////

    // For set active menu
    $(parent_id + " .custom-menu").each(function () {
        var _this = $(this);
        _this.children("li").each(function () {
            var _child = $(this);
            if (window.location.pathname.indexOf(_child.attr("id")) >= 0) {
                _child.addClass("active");
            } else {
                _child.removeClass("active");
            }
        });
        var _parent = $(_this.attr('data-parent'));
        _parent.click();
    });

    /////////////////////////////
    $(parent_id + ' .custom-trigger-tab').each(function () {
        var _this = $(this);
        _this.on('click', function () {
            $('a[href=' + _this.attr('href') + ']:not(.custom-trigger-tab)').trigger('click');
        });

    });
    /////////////////////////////
    //$('.validateform').validationEngine();
    ////////////////////////////
    $(parent_id + ' .custom-ajax-form').each(function() {
        var _this = $(this);
        var form = _this.find('form');

        form.submit(function () {
            var form = $(this);
            // return false if form still have some validation errors
            if (form.find('.has-error').length) {
                return false;
            }
            // submit form
            $.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function (response) {
                    form.closest('.custom-ajax-form').empty().append(response);
                }
            });
            return false;
        });
    })
}

function uiUpdate(parent_id) {
    parent_id = typeof (parent_id) === 'undefined' ? '' : parent_id;


    // Update for step workflow
    $(parent_id + ' .step-nav').each(function () {
        var _this = $(this);
        var _childrens = _this.children();
        var _length = _childrens.length;
        for (var i = 0; i < _length; i++) {
            var _child = _childrens.eq(i);
            if (i >= step) {
                console.log(_child);
                _child.find('a').addClass('dis');
            } else if (i == step - 1) {
                _child.find('a').addClass('active');
            }
        }
    });

    // Create date format for class="date-format-convert" date-format="DMY".
    /*******************************************************/
    $(parent_id + ".date-format-convert").each(function () {
        var _this = $(this);
        var value = this.textContent.trim();
        if (checkUndefine(value) || value == '' || !isDate(value, 'yyyy-MM-dd'))
            return;
        _this.empty();
        //////console.log(getDateFromFormat(value, 'yyyy-MM-dd'));
        _this.append(formatDate(parseDate(value), 'dd/MM/yyyy'));
    });

    $(parent_id + ".datetime-format-convert").each(function () {
        var _this = $(this);
        var value = this.textContent.trim();

        if (checkUndefine(value) || value == '' || !isDate(value, 'yyyy-MM-dd HH:mm:ss')) {
            return;
        }

        _this.empty();
        //////console.log(getDateFromFormat(value, 'yyyy-MM-dd'));
        _this.append(formatDate(new Date(getDateFromFormat(value, 'yyyy-MM-dd HH:mm:ss')), 'dd/MM/yyyy'));
    });

    $(parent_id + ".date-format-convert-input").each(function () {
        var _this = $(this);
        var value = _this.val().trim();
        if (checkUndefine(value) || value == '' || !isDate(value, 'yyyy-MM-dd'))
            return;
        _this.empty();
        _this.datepicker('setDate', parseDate(value));
    });

    //////////////////////////////////////
    /********************************************************************
     // Export word: btn-word-export, target: data-target
     /********************************************************************/
    $(parent_id + ".btn-word-export").on('click', function (e) {
        // Escape default functional
        e.preventDefault();
        // Get target data
        var _this = $(this);
        var target = _this.attr('data-target');
        var filename = _this.attr('data-filename');
        var _url = _this.attr('data-url');
        var _filter = _this.attr('data-filter');
        // Check valid target
        if (!checkUndefine(_url)) {
            $.ajax({
                url: _url,
                data: $(_filter).serialize(),
                success: function (data) {
                    $(target).empty().append(data);
                    $(target).wordExport(filename);
                }
            });
            return;
        }

        if (checkUndefine(target)) {
            return;
        }
        // Check filename
        if (checkUndefine(filename)) {
            filename = 'ExportFile';
        }
        // Export as word
        $(target).wordExport(filename);
    });
/////////////////////////////////////////////////
//    $(parent_id + ' .selectpicker').selectpicker();
    ////////////////////////////////////////////
    uiMenuUpdate();

}

function uiMenuUpdate() {
    $(' .custom-active-menu').each(function () {
        var _this = $(this);
        var menu = $(_this.attr('data-menu'));
        menu.addClass('active');
    });

    if (window.location.hash !== "") {
        $('a[href="' + window.location.hash + '"]').click()
    }


}

function callAjaxFunction() {

    var _this = $(this);
    var urlajax = _this.attr('data-ajax-url');
    var methodajax = _this.attr('data-ajax-method');
    var isreload = _this.attr('data-ajax-reload');
    var _form = $(_this.attr('data-ajax-form'));

    $.ajax({
        url: urlajax,
        data: !checkUndefine(_form) ? _form.serialize() : {},
        method: !checkUndefine(methodajax) ? methodajax : 'POST',
        success: function (link) {
            if (!checkUndefine(isreload) && isreload) {
                //console.log(link);
                window.location = link;
            }
        }
    });
}

function checkUndefine(objCheck) {
    return typeof(objCheck) === 'undefined';
}
