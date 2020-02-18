// @ts-check
if ($) $(function() {
    const eltoremove = $('a[href*="Authentication/password_recovery"')
    if (eltoremove.length == 1) {
        const parent = eltoremove.parent()
        eltoremove.remove()
        if (parent.text().trim().length == 0) {
            parent.remove();
        }
    }
})