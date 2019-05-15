<?php

namespace RUB\UITrimmerExternalModule;

require_once "em-i18n-polyfill/em-i18n-polyfill.php";

use ExternalModules\TranslatableExternalModule;

/**
 * ExternalModule class for Localization Demo.
 * This demo module will get a string and print it to the browser's
 * console as info, warning, or error, depending on the module's 
 * settings.
 */
class UITrimmerExternalModule extends TranslatableExternalModule {

    private $settings;


    function __construct() {
        parent::__construct("English");
        // Initialize settings.
        $this->settings = new UITrimmerSettings($this);
    }

    function redcap_every_page_top($project_id = null) {

        echo "<style>body{display:none}</style>";

        $doIt = SUPER_USER != 1 || $this->settings->forSuperUsers;

        // Remove Codebook link.
        if ($doIt && $this->settings->removeCodebookLink) {
            $this->includeScriptlet("remove-codebook-link");
        }

        // Remove My Projects link.
        if ($doIt && $this->settings->removeMyProjectsLink) {
            $this->includeScriptlet("remove_myprojects_link");
        }

        // Remove empty menu sections.
        if ($doIt && $this->settings->removeEmptyMenuSections) {
            $this->includeScriptlet("remove_empty_menu_sections");
        }

        // Remove Current Users.
        if ($doIt && $this->settings->removeCurrentUsersBox) {
            $this->includeScriptlet("remove-current-users");
        }

        // Remove Upcoming Calendar Events.
        if ($doIt && $this->settings->removeUpcomingEventsBox) {
            $this->includeScriptlet("remove-upcoming-events");
        }

        // Remove Action buttons on data entry pages.
        if ($doIt && $this->settings->removeTopActions) {
            $this->includeScriptlet("remove_top_actions");
        }

        // Remove Forgot your password link on the login page.
        if ($doIt && $this->settings->removeForgotPasswordLink) {
            $this->includeScriptlet("remove_forgot_password");
        }

        // Remove items below login on the login page.
        if ($doIt && $this->settings->removeItemsBelowLogin) {
            $this->includeScriptlet("remove_items_below_login");
        }

        // Reveal
        echo "<script>$(function() { $('body').show() })</script>";
    }

    private $scriptlets = array (
        "remove-current-users" => 
            "$(function() {
                const eltoremove = $('div#user_list')
                if (eltoremove.length == 1) {
                    const parent = eltoremove.parent()
                    eltoremove.remove()
                    if (parent.text().trim().length == 0) {
                        parent.remove();
                    }
                }
            })",
        "remove-upcoming-events" => 
            "$(function() {
                const eltoremove = $('div#cal_table')
                if (eltoremove.length == 1) {
                    const parent = eltoremove.parent()
                    eltoremove.remove()
                    if (parent.text().trim().length == 0) {
                        parent.remove();
                    }
                }
            })",
        "remove-codebook-link" => 
            "$(function() {
                const eltoremove = $('div.menubox a[href*=\"Design/data_dictionary_codebook\"]').parent()
                if (eltoremove.length == 1) {
                    const elbefore = eltoremove.first().prev('span')
                    if (elbefore.text().length == 1) {
                        elbefore.remove();
                    }
                    eltoremove.remove();
                }
            })",
        "remove_empty_menu_sections" =>
            "$(function() {
                $('div#west div.x-panel-body').each(function() {
                    if ($(this).text().length == 0) {
                        $(this).parent().parent().hide()
                    }
                })
            })",
        "remove_top_actions" => 
            "$(function() {
                const eltoremove = $('div#dataEntryTopOptionsButtons')
                if (eltoremove.length == 1) {
                    eltoremove.remove();
                }
            })",
        "remove_forgot_password" => 
            "$(function() {
                const eltoremove = $('a[href*=\"Authentication/password_recovery\"')
                if (eltoremove.length == 1) {
                    const parent = eltoremove.parent()
                    eltoremove.remove()
                    if (parent.text().trim().length == 0) {
                        parent.remove();
                    }
                }
            })",
        "remove_items_below_login" => 
            "$(function() {
                const eltoremove = $('div#left_col').siblings('div.row')
                if (eltoremove.length == 1) {
                    eltoremove.remove()
                }
            })",
        "remove_myprojects_link" => 
            "",
    );

    private function includeScriptlet($name) {
        if ($this->settings->debugMode) {
            echo '<script type="text/javascript" src="' . $this->framework->getUrl("js/{$name}.js") . '"></script>';
        }
        else {
            echo "<script type=\"text/javascript\">{$this->scriptlets[$name]}</script>";
        }
    }
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
    public $removeEmptyMenuSections = false;
    public $removeCurrentUsersBox = false;
    public $removeUpcomingEventsBox = false;
    public $removeTopActions = false;
    public $removeForgotPasswordLink = false;
    public $removeItemsBelowLogin = false;

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
            $this->removeCurrentUsersBox = $this->getPS("remove_current_users", false);
            $this->removeUpcomingEventsBox = $this->getPS("remove_upcoming_events", false);
            $this->removeEmptyMenuSections = $this->getPS("remove_empty_menu_sections", false);
            $this->removeTopActions = $this->getPS("remove_top_actions", false);
            $this->removeForgotPasswordLink = $this->getPS("remove_forgot_password", false);
            $this->removeItemsBelowLogin = $this->getPS("remove_items_below_login", false);
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

