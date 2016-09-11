!function(global, $) {
    'use strict';

    function ConcretePageSelector($element, options) {
        'use strict';
        var my = this,
            options = $.extend({
                'chooseText': ccmi18n_sitemap.choosePage,
                'loadingText': ccmi18n_sitemap.loadingText,
                'inputName': 'cID',
                'cID': 0
            }, options);

        my.$element = $element;
        my.options = options;
        my._chooseTemplate = _.template(my.chooseTemplate, {'options': my.options});
        my._loadingTemplate = _.template(my.loadingTemplate, {'options': my.options});
        my._pageLoadedTemplate = _.template(my.pageLoadedTemplate);
        my._pageMenuTemplate = _.template(ConcretePageAjaxSearchMenu.get());

        my.$element.append(my._chooseTemplate);
        my.$element.on('click', 'a[data-page-selector-link=choose]', function(e) {
            e.preventDefault();
            ConcretePageAjaxSearch.launchDialog(function(data) {
                my.loadPage(data.cID);
            });
        });

        if (my.options.cID) {
            my.loadPage(my.options.cID);
        }
    }

    ConcretePageSelector.prototype = {


        chooseTemplate: '<div class="ccm-page-selector">' +
            '<input type="hidden" name="<%=options.inputName%>" value="0" /><a href="#" data-page-selector-link="choose"><%=options.chooseText%></a></div>',
        loadingTemplate: '<div class="ccm-page-selector"><div class="ccm-page-selector-choose"><i class="fa fa-spin fa-spinner"></i> <%=options.loadingText%></div></div>',
        pageLoadedTemplate: '<div class="ccm-page-selector"><div class="ccm-page-selector-page-selected">' +
            '<input type="hidden" name="<%=inputName%>" value="<%=page.cID%>" />' +
            '<a data-page-selector-action="clear" href="#" class="ccm-page-selector-clear"><i class="fa fa-close"></i></a>' +
            '<div class="ccm-page-selector-page-selected-title"><%=page.name%></div>' +
            '</div></div>',

        loadPage: function(cID) {
            var my = this;
            my.$element.html(my._loadingTemplate);
            ConcretePageAjaxSearch.getPageDetails(cID, function(r) {
                var page = r.pages[0];
                my.$element.html(my._pageLoadedTemplate({'inputName': my.options.inputName, 'page': page}));
                my.$element.on('click', 'a[data-page-selector-action=clear]', function(e) {
                    e.preventDefault();
                    my.$element.html(my._chooseTemplate);
                });
            });
        }
    }

    // jQuery Plugin
    $.fn.concretePageSelector = function(options) {
        return $.each($(this), function(i, obj) {
            new ConcretePageSelector($(this), options);
        });
    }

    global.ConcretePageSelector = ConcretePageSelector;

}(this, $);
