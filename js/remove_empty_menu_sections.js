// @ts-check
if ($) $(function() {
    $('div#west div.x-panel-body').each(function() {
        if ($(this).text().length == 0) {
            $(this).parent().parent().hide()
        }
    })
})