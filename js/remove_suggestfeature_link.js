// @ts-check
if ($) $(function() {
    let eltoremove = $('div.menubox a[href*="vanderbilt.edu/enduser_survey"]').parent()
    if (eltoremove.length === 1) eltoremove.remove()
})