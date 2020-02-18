// @ts-check
if ($) $(function() {
    const eltoremove = $('div#user_list')
    if (eltoremove.length == 1) {
        const parent = eltoremove.parent()
        eltoremove.remove()
        if (parent.text().trim().length == 0) {
            parent.remove();
        }
    }
})