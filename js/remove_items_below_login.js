// @ts-check
$(function() {
    const eltoremove = $('div#left_col').siblings('div.row')
    if (eltoremove.length == 1) {
        eltoremove.remove()
    }
})