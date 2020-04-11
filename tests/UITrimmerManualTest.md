# UI Trimmer - Manual Testing Procedure

Version 1 - 2020-04-11

## Prerequisites

- A project with a limited role (**only** Create Records).
- A user in this limited role.
- The _Enable the Field Comment Log or Data Resolution Workflow (Data Queries)?_ option is turned off in _Additional customizations_.
- UI Trimmer enabled for this project.
- No other external modules should be enabled, except those with which this module's interaction should be tested.

## Test Procedure

1. Using an admin account, configure the module: Turn on **all** options (except _Modify the Help & FAQ link_).
1. Go to the _Project Home_ page and log out (or browse to _Project Home_ in a new private window).
1. Verify the following:
   - The "Forgot your password?" link is **not** showing.
   - The "Welcome to REDCap!" and "REDCap Features" boxes are **not** showing.
   - Thuse, the footer with the REDCap version should be shown immediatly under the "Log In" button.
1. Log in using the limited user account.
1. Verify the following:
   - On the _Project Home_ page, the "Current Users" and "Upcoming Calendar Events" boxes are **not** shown. The "Project Statistics" should still be shown.
   - The "Codebook" link is **not** shown in the _Project Home and Design_ section of the main menu.
   - The "My Projects" link is **not** shown at the top of the main menu.
   - The "Video Tutorials" link is **not** shown in the _Help & Information_ section of the main menu.
   - The "Help & FAQ" link is **not** shown in the _Help & Information_ section of the main menu.
   - The "Suggest a New Feature" link is **not** shown in the _Help & Information_ section of the main menu.
   - As the _Applications_ section of the main menu should be empty, it is **not** displayed.
1. Go to the _Add / Edit Records_ page and click on "Add new record".
1. Verify the following:
   - The "Actions" items (such as "Download PDF of instrument(s)") are **not** shown.
1. Using the admin account, modifiy the module's configuration and **turn on** the _Modify the Help & FAQ link (new text and link target)_ option (with appropriate some values for link text and web address) and **turn off** the _Remove the Help & FAQ link from the menu_ option.
1. Refresh the browser window for the limited user or simply click on the "Project Home" link.
1. Verify the following:
   - The "Help & FAQ" link **is** showing with the **modified** link text in the _Help & Information_ section of the main menu.
   - Clicking on the link does lead to the set target address.

Done.

## Reporting Errors

Before reporting errors:
- Make sure there is no interference with any other external module by turning off all others and repeating the tests.
- Check if you are using the latest version of the module. If not, see if updating fixes the issue.

To report an issue:
- Please report errors by opening an issue on [GitHub](https://github.com/grezniczek/redcap_ui_trimmer/issues) or on the community site (please tag @gunther.rezniczek). 
- Include essential details about your REDCap installation such as **version** and platform (operating system, PHP version).
- If the problem occurs only in conjunction with another external module, please provide its details (you may also want to report the issue to that module's authors).
