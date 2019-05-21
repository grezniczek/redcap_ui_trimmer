// @ts-check
$(function() {
    const elToModify = $('div.menubox a[onclick*="helpPopup"]') 
    if (elToModify.length === 1) {
        const em = $lang.getEMHelper('redcap_ui_trimmer')
        const text = em.get('modified_text')
        if (text.length > 0) elToModify.html(text)
        const url = em.get('modified_url')
        if (url.length > 0) {
            elToModify.attr('href', url)
            elToModify.prop('onclick', null).off('click')
            elToModify.attr('target', '_blank')
        }
    }
})