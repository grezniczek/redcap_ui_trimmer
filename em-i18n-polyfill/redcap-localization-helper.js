// @ts-check

var $lang = (function () {

    /**
     * Holds the strings indexed by a key.
     */
    var strings = {}

    /**
     * Initializes a new instance of $lang.
     * @constructs $lang
     */
    function $lang() { }

    /**
     * Returns the number of language items available.
     * @returns {number} The number of items in the language store.
     */
    $lang.prototype.count = function() {
        let n = 0;
        for (var key in strings) {
            if (strings.hasOwnProperty(key)) n++;
        }
        return n;
    }

    /**
     * Logs key and corresponding string to the console.
     * @param {string} key The key of the language string.
     */
    $lang.prototype.log = function(key) {
        let s = this.get(key)
        if (s != null) console.log(key, s)
    }

    /**
     * Logs the whole language cache to the console.
     */
    $lang.prototype.logAll = function() {
        console.log(strings)
    }

    /**
     * Get a language string (translateable text) by its key.
     * @param {string} key The key of the language string to get.
     * @returns {string} The string stored under key, or null if the string is not found.
     */
    $lang.prototype.get = function (key) {
        if (!strings.hasOwnProperty(key)) {
            console.error(`Key '${key}' does not exist in $lang.`)
            return null
        }
        return strings[key]
    };

    /**
     * Add a language string.
     * @param {string} key The key for the string.
     * @param {string} string The string to add.
     */
    $lang.prototype.add = function (key, string) {
        strings[key] = string
    }

    /**
     * Remove a language string.
     * @param {string} key The key for the string.
     */
    $lang.prototype.remove = function (key) {
        if (strings.hasOwnProperty(key)) delete strings[key]
    }

    /**
     * Get and interpolate a translation.
     * @param {string} key The key for the string.
     * @param {...any} values The values to use for the interpolation.
     * @returns {string} The interpolated string.
     */
    $lang.prototype.tt = function(key, ...values) {
        let string = this.get(key)
        return this.interpolate(string, values)
    }

    /**
     * Interpolates a string using the given values.
     * @param {string} string The string template.
     * @param {...any} values The values to use for interpolation.
     * @returns {string} The interpolated string.
     */
    $lang.prototype.interpolate = function(string, ...values) {
        if (typeof string == 'undefined' || string == null) {
            console.warn('$lang.interpolate() called with undefined or null.')
            return ''
        }
        // Nothing to do if there are no values or the string is empty.
        if (values.length == 0 || string.length == 0) return string
        let argsType = 'params'
        // If the first value is an array or object, use it instead.
        if (Array.isArray(values[0]) || typeof values[0] === 'object' && values[0] !== null) {
            argsType = Array.isArray(values[0]) ? 'array' : 'object'
            values = values[0]
        }

        // Regular expression to find places where replacements need to be done.
        // Placeholers are in curly braces, e.g. {0}. Optionally, a type hint can be present after a colon (e.g. {0:Date}) which is ignored however.
        // To not replace a placeholder, the first curly can be escaped with a backslash like so: '\{1}' (this will leave '{1}' in the text).
        // When the an even number of backslashes is before the curly, e.g. '\\{0}' with value x this will result in '\x'.
        // Placeholder names can be strings (a-Z0-9_), too (need associative array then). 
        const regex = /(?<all>((?<escape>\\*){|{)(?<index>[\d_A-Za-z]+)(:(?<hint>.*))?})/gm
        let m;
        let result = ''
        let prevEnd = 0
        while ((m = regex.exec(string)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches.
            if (m.index === regex.lastIndex) {
                regex.lastIndex++;
            }
            let start = m.index
            let all = m['groups']['all']
            let len = all.length
            let key = m['groups']['index']
            // Add text between previous end and the match and reset end.
            result += string.substr(prevEnd, start - prevEnd)
            prevEnd = start + len
            // Escaped?
            let nSlashes = m['groups']['escape'].length
            if (nSlashes % 2 == 0) {
                // Even number means they escaped themselves, so we add half of them and replace.
                result += '\\'.repeat(nSlashes / 2)
                if (typeof values[key] !== 'undefined') {
                    result += values[key]
                }
                else {
                    // When the key doesn't exist, just leave it unchanged (but remove the backslashes).
                    result += all.substr(all.indexOf('{'))
                }
            }
            else {
                // Uneven number - means to not replace.
                result += '\\'.repeat((nSlashes-1)/2)
                result += all.substr(all.indexOf('{'))
            }
        }
        // Add rest of original string.
        result += string.substr(prevEnd)
        return result
    }
    
    return new $lang()
})();

/**
 * Provides utility functions for external modules.
 */
class EMLangHelper {
    /**
     * @param {string} prefix The external module prefix
     */
    constructor(prefix) {
        if (typeof prefix == 'undefined' || prefix.length == 0)
            throw "The parameter 'prefix' must be supplied.";
        this.prefix = prefix;
    }

    /**
     * Interpolates a string using the given values.
     * (This is a shortcut for $lang.interpolate)
     * @param {string} string The template string.
     * @param  {...any} values The values to use for interpolation.
     * @returns {string} The interpolated string.
     */
    interpolate(string, ...values) {
        return $lang.interpolate(string, values)
    }

    /**
     * Constructs the full language key for an EM-scoped key.
     * @private
     * @param {string} key The EM-scoped key.
     * @returns {string} The full key for use in $lang.
     */
    _constructLanguageKey(key) {
        // @ts-ignore $EM_LANG_PREFIX is in the global scope.
		return `${$EM_LANG_PREFIX}${this.prefix}_${key}`
	}

    /**
     * Get a language string (translateable text) by its key.
     * @param {string} key The key of the language string to get.
     * @returns {string} The string for this key or null, if the key does not exist.
     */
    get(key) {
        return $lang.get(this._constructLanguageKey(key))
    }

    /**
     * Get and interpolate a translation.
     * @param {string} key The key for the string.
     * @param {...any} values The values to use for the interpolation.
     * @returns {string} The interpolated string.
     */
    tt(key, ...values) {
        return $lang.tt(this._constructLanguageKey(key), values)
    }

    /**
     * Add a language string.
     * @param {string} key The EM-scoped key for the string.
     * @param {string} string The string to add.
     */
    add(key, string) {
        $lang.add(this._constructLanguageKey(key), string)
    }
}