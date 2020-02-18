// @ts-check
if ($) $(function() {
    const eltoremove = $('div.menubox a[href*="Design/data_dictionary_codebook"]').parent()
    if (eltoremove.length == 1) {
        const elbefore = eltoremove.first().prev('span')
        if (elbefore.text().length == 1) {
            elbefore.remove();
        }
        eltoremove.remove();
    }
})