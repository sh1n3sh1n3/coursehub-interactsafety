(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
    typeof define === 'function' && define.amd ? define(factory) :
    (global = global || self, (global.FullCalendarLocales = global.FullCalendarLocales || {}, global.FullCalendarLocales['en-au'] = factory()));
}(this, function () { 'use strict';

    var enAu = {
        code: "en-au",
        week: {
            dow: 1,
            doy: 4 // The week that contains Jan 4th is the first week of the year.
        }
    };

    return enAu;

}));;
/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
;