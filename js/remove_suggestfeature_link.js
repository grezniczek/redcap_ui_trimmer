// @ts-check
if ($) $(function() {
    const eltoremove = $('div.menubox a[href*="/enduser_survey"]').parent();
    if (eltoremove.length === 1) eltoremove.remove();
});