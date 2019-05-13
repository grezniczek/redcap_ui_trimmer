# UI Trimmer

A REDCap External Module to remove some of REDCap's menus and other UI elements.

## Requirements

- REDCAP 8.1.0 or newer (tested with 9.0.1).

## Installation

- Clone this repo into `<redcap-root>/modules/redcap_ui_trimmer_v<version-number>`.
- Go to _Control Center > Technical / Developer Tools > External Modules_ and enable _UI Trimmer_.

## Configuration

### System-level settings

- **Debug mode** - when enabled, JavaScript will not be inlined but called as separat script files. This facilitates debugging.
- **Enable for Super Users** - Normally, any UI-removals do not apply for Super Users. Activate this setting to have the module remove UI elements even for them.

### Project-level settings

- Toggle removal of various UI elements.