// @ts-check
if ($) $(function() {
    $('div#west div.x-panel-body').each(function() {
        if ($(this).text().length == 0) {
            const $menuSection = $(this).parent().parent();
            if ($menuSection.find('a').length < 2) {
                $menuSection.hide();
            }
        }
    });
})