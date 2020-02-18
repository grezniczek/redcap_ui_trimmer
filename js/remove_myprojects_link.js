// @ts-check
if ($) $(function() {
    const eltoremove = $('div.menubox a[href*="index.php?action=myprojects"]')
    eltoremove.each(function() {
        let el = $(this)
        let elbefore = el.prev('i')
        if (elbefore.length == 1) {
            let elafter = el.next('span')
            this.previousSibling.nodeValue = ''
            elbefore.remove()
            elafter.remove()
            el.remove()
        }
        else {
            el.removeAttr('href')
        }
    })
})