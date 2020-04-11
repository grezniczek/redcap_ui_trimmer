# UI Trimmer

A REDCap External Module to remove some of REDCap's menus and other UI elements.

## Requirements

- REDCAP 9.5.0 or newer (tested with 9.5.8, 9.8.2).

## Installation

- Clone this repo into `<redcap-root>/modules/redcap_ui_trimmer_v<version-number>`.
- Go to _Control Center > Technical / Developer Tools > External Modules_ and enable _UI Trimmer_.

## Configuration

### System-level settings

- **Debug mode** - when enabled, JavaScript will not be inlined but called as separate script files. This facilitates debugging.
- **Enable for Super Users** - Normally, any UI-removals do not apply for Super Users. Activate this setting to have the module remove UI elements even for them.

### Project-level settings

Toggle removal of or change the appearance of various UI elements:

- Remove the _My Projects_ link from the menu
- Remove the _Codebook_ link from the menu
- Remove the _Video Tutorials_ link from the menu
- Remove the _Help & FAQ_ link from the menu
- Modify the _Help & FAQ_ link (text, link target)
- Remove the _Suggest a New Feature_ link from the menu
- Remove all empty menu sections
- Remove items from **Project Home**:
  - Current Users
  - Upcoming Calendar Event
- Remove items from **Data Entry** pages:
  - Remove actions
- Remove items from the **Login** page:
  - Remove the _Forgot your password?_ link
  - Remove the items below the line under the _Log In_ button

## Testing

Instructions for testing the module can be found [here](?prefix=redcap_ui_trimmer&page=tests/UITrimmerManualTest.md).

## Changelog

Version | Changes
------- | -----------
1.0.3   | Add instructions for testing the module.
1.0.2   | Add checks for presence of jQuery to prevent JS errors.
1.0.1   | Fix incompatibility with REDCap version 9.5.0.
1.0.0   | Initial release.
