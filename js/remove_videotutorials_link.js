// @ts-check
if ($) $(function() {
    let eltoremove = $('div.menubox a[onclick*="#menuvids"], div.menubox a[href*="?action=training"]').parent()
    if (eltoremove.length === 1) eltoremove.remove()
    eltoremove = $('#menuvids')
    if (eltoremove.length === 1) eltoremove.remove()
})