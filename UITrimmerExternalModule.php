<?php

namespace RUB\UITrimmerExternalModule;

use ExternalModules\AbstractExternalModule;

/**
 * ExternalModule class for Localization Demo.
 * This demo module will get a string and print it to the browser's
 * console as info, warning, or error, depending on the module's 
 * settings.
 */
class UITrimmerExternalModule extends AbstractExternalModule {

    private $settings;
    private $scriptlets = array();

    function redcap_every_page_top($project_id = null) {

        $this->settings = new UITrimmerSettings($this);
        $this->addScriptlets();

        echo "<style>body{display:none}</style>";

        $doIt = SUPER_USER != 1 || $this->settings->forSuperUsers;

        // Remove Codebook link.
        if ($doIt && $this->settings->removeCodebookLink) {
            $this->includeScriptlet(ActionsEnum::remove_codebook_link);
        }

        // Remove My Projects link.
        if ($doIt && $this->settings->removeMyProjectsLink) {
            $this->includeScriptlet(ActionsEnum::remove_myprojects_link);
        }

        // Remove Video Tutorials link.
        if ($doIt && $this->settings->removeVideoTutorialsLink) {
            $this->includeScriptlet(ActionsEnum::remove_videotutorials_link);
        }

        // Remove Help & FAQ link.
        if ($doIt && $this->settings->removeHelpLink) {
            $this->includeScriptlet(ActionsEnum::remove_help_link);
        }

        // Modify Help & FAQ link.
        if ($doIt && !$this->settings->removeHelpLink && $this->settings->modifyHelpLink) {
            $this->includeScriptlet(ActionsEnum::modify_help_link, true);
        }

        // Remove Suggest a New Feature link.
        if ($doIt && $this->settings->removeSuggestFeatureLink) {
            $this->includeScriptlet(ActionsEnum::remove_suggestfeature_link);
        }

        // Remove empty menu sections.
        if ($doIt && $this->settings->removeEmptyMenuSections) {
            $this->includeScriptlet(ActionsEnum::remove_empty_menu_sections);
        }

        // Remove Current Users.
        if ($doIt && $this->settings->removeCurrentUsersBox) {
            $this->includeScriptlet(ActionsEnum::remove_current_users);
        }

        // Remove Upcoming Calendar Events.
        if ($doIt && $this->settings->removeUpcomingEventsBox) {
            $this->includeScriptlet(ActionsEnum::remove_upcoming_events);
        }

        // Remove Action buttons on data entry pages.
        if ($doIt && $this->settings->removeTopActions) {
            $this->includeScriptlet(ActionsEnum::remove_top_actions);
        }

        // Remove Forgot your password link on the login page.
        if ($doIt && $this->settings->removeForgotPasswordLink) {
            $this->includeScriptlet(ActionsEnum::remove_forgot_password);
        }

        // Remove items below login on the login page.
        if ($doIt && $this->settings->removeItemsBelowLogin) {
            $this->includeScriptlet(ActionsEnum::remove_items_below_login);
        }

        // Reveal
        echo "<script>
            (function() {
                var callback = function() {
                    document.body.style.display = 'block'
                }
                if (document.readyState === 'complete' || (document.readyState !== 'loading' && !document.documentElement.doScroll)) {
                    callback()
                }
                else {
                    document.addEventListener('DOMContentLoaded', callback)
                }
            })()
        </script>";
    }

    private function addScriptlets() {
        $this->scriptlets[ActionsEnum::remove_current_users] =
            "if ($) $(function() {
                const eltoremove = $('div#user_list')
                if (eltoremove.length == 1) {
                    const parent = eltoremove.parent()
                    eltoremove.remove()
                    if (parent.text().trim().length == 0) {
                        parent.remove();
                    }
                }
            })";
        $this->scriptlets[ActionsEnum::remove_upcoming_events] =
            "if ($) $(function() {
                const eltoremove = $('div#cal_table')
                if (eltoremove.length == 1) {
                    const parent = eltoremove.parent()
                    eltoremove.remove()
                    if (parent.text().trim().length == 0) {
                        parent.remove();
                    }
                }
            })";
        $this->scriptlets[ActionsEnum::remove_codebook_link] = 
            "if ($) $(function() {
                const eltoremove = $('div.menubox a[href*=\"Design/data_dictionary_codebook\"]').parent()
                if (eltoremove.length == 1) {
                    const elbefore = eltoremove.first().prev('span')
                    if (elbefore.text().length == 1) {
                        elbefore.remove();
                    }
                    eltoremove.remove();
                }
            })";
        $this->scriptlets[ActionsEnum::remove_help_link] =
            "if ($) $(function() {
                const eltoremove = $('div.menubox a[onclick*=\"helpPopup\"]').parent()
                if (eltoremove.length === 1) eltoremove.remove()
            })";
        $this->scriptlets[ActionsEnum::modify_help_link] =
            "if ($) $(function() {
                const elToModify = $('div.menubox a[onclick*=\"helpPopup\"]') 
                if (elToModify.length === 1) {
                    const text = " . json_encode($this->settings->modifiedHelpLinkText) . "
                    if (text.length > 0) elToModify.html(text)
                    const url = " . json_encode($this->settings->modifiedHelpLinkUrl) . "
                    if (url.length > 0) {
                        elToModify.attr('href', url)
                        elToModify.prop('onclick', null).off('click')
                        elToModify.attr('target', '_blank')
                    }
                }
            })";
        $this->scriptlets[ActionsEnum::remove_videotutorials_link] =
            "if ($) $(function() {
                let eltoremove = $('div.menubox a[onclick*=\"#menuvids\"]').parent()
                if (eltoremove.length === 1) eltoremove.remove()
                eltoremove = $('#menuvids')
                if (eltoremove.length === 1) eltoremove.remove()
            })";
        $this->scriptlets[ActionsEnum::remove_suggestfeature_link] =
            "if ($) $(function() {
                let eltoremove = $('div.menubox a[href*=\"vanderbilt.edu/enduser_survey\"]').parent()
                if (eltoremove.length === 1) eltoremove.remove()
            })";
        $this->scriptlets[ActionsEnum::remove_empty_menu_sections] = 
            "if ($) $(function() {
                $('div#west div.x-panel-body').each(function() {
                    if ($(this).text().length == 0) {
                        $(this).parent().parent().hide()
                    }
                })
            })";
        $this->scriptlets[ActionsEnum::remove_top_actions] =
            "if ($) $(function() {
                const eltoremove = $('div#dataEntryTopOptionsButtons')
                if (eltoremove.length == 1) {
                    eltoremove.remove();
                }
            })";
        $this->scriptlets[ActionsEnum::remove_forgot_password] =
            "if ($) $(function() {
                const eltoremove = $('a[href*=\"Authentication/password_recovery\"')
                if (eltoremove.length == 1) {
                    const parent = eltoremove.parent()
                    eltoremove.remove()
                    if (parent.text().trim().length == 0) {
                        parent.remove();
                    }
                }
            })";
        $this->scriptlets[ActionsEnum::remove_items_below_login] =
            "if ($) $(function() {
                const eltoremove = $('div#left_col').siblings('div.row')
                if (eltoremove.length == 1) {
                    eltoremove.remove()
                }
            })";
        $this->scriptlets[ActionsEnum::remove_myprojects_link] =
            "if ($) $(function() {
                const eltoremove = $('div.menubox a[href*=\"index.php?action=myprojects\"]')
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
            })";
    }

    private function includeScriptlet($name, $inline = false) {
        if (!$inline && $this->settings->debugMode) {
            echo '<script type="text/javascript" src="' . $this->framework->getUrl("js/{$name}.js") . '"></script>';
        }
        else {
            echo "<script type=\"text/javascript\">{$this->scriptlets[$name]}</script>";
        }
    }
}

class ActionsEnum {
    const modify_help_link = "modify_help_link";
    const remove_codebook_link = "remove_codebook_link";
    const remove_current_users = "remove_current_users";
    const remove_empty_menu_sections = "remove_empty_menu_sections";
    const remove_forgot_password = "remove_forgot_password";
    const remove_help_link = "remove_help_link";
    const remove_items_below_login = "remove_items_below_login";
    const remove_myprojects_link = "remove_myprojects_link";
    const remove_suggestfeature_link = "remove_suggestfeature_link";
    const remove_top_actions = "remove_top_actions";
    const remove_upcoming_events = "remove_upcoming_events";
    const remove_videotutorials_link = "remove_videotutorials_link";
}
/**
 * Helper class for retrieving module config.
 */
class UITrimmerSettings {

    private $m;

    public $debugMode = false;
    public $forSuperUsers = false;
    
    public $removeCodebookLink = false;
    public $removeMyProjectsLink = false;
    public $removeVideoTutorialsLink = false;
    public $removeHelpLink = false;
    public $removeSuggestFeatureLink = false;
    public $removeEmptyMenuSections = false;
    public $removeCurrentUsersBox = false;
    public $removeUpcomingEventsBox = false;
    public $removeTopActions = false;
    public $removeForgotPasswordLink = false;
    public $removeItemsBelowLogin = false;
    public $modifyHelpLink = false;
    public $modifiedHelpLinkText = "";
    public $modifiedHelpLinkUrl = "";

    function __construct($module) 
    {
        $this->isProject = isset($GLOBALS["project_id"]);
        $this->m = $module;
        $this->debugMode = $this->getSS("debug_mode", false);
        $this->forSuperUsers = $this->getSS("even_for_superuser", false);

        // Settings in the context of a project.
        if ($this->isProject) {
            $this->removeCodebookLink = $this->getPS("remove_codebook_link", false);
            $this->removeMyProjectsLink = $this->getPS("remove_myprojects_link", false);
            $this->removeVideoTutorialsLink = $this->getPS("remove_videotutorials_link", false);
            $this->removeHelpLink = $this->getPS("remove_help_link", false);
            $this->removeSuggestFeatureLink = $this->getPS("remove_suggestfeature_link", false);
            $this->removeCurrentUsersBox = $this->getPS("remove_current_users", false);
            $this->removeUpcomingEventsBox = $this->getPS("remove_upcoming_events", false);
            $this->removeEmptyMenuSections = $this->getPS("remove_empty_menu_sections", false);
            $this->removeTopActions = $this->getPS("remove_top_actions", false);
            $this->removeForgotPasswordLink = $this->getPS("remove_forgot_password", false);
            $this->removeItemsBelowLogin = $this->getPS("remove_items_below_login", false);
            $this->modifyHelpLink = $this->getPS("modify_help_link", false);
            $this->modifiedHelpLinkText = $this->getPS("modify_help_text", "");
            $this->modifiedHelpLinkUrl = $this->getPS("modify_help_url", "");
        }
    }

    /**
     * Get a project setting value.
     * @param string $name The key of the setting.
     * @param mixed $default A default value.
     * @return mixed The value of the setting.
     */
    private function getPS($name, $default) 
    {
        $value = $this->m->getProjectSetting($name);
        return strlen($value) ? $value : $default;
    }

    /**
     * Get a system setting value.
     * @param string $name The key of the setting.
     * @param mixed $default A default value.
     * @return mixed The value of the setting.
     */
    private function getSS($name, $default) 
    {
        $value = $this->m->getSystemSetting($name);
        return strlen($value) ? $value : $default;
    }
}

