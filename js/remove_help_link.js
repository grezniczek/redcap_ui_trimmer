// @ts-check
if ($) if ($) $(function() {
    const eltoremove = $('div.menubox a[onclick*="helpPopup"]').parent()
    if (eltoremove.length === 1) eltoremove.remove()
})