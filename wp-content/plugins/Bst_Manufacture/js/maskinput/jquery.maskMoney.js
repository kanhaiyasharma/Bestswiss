(function (jQuery) {
    "use strict";
    if (!jQuery.browser) {
        jQuery.browser = {};
        jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
        jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
        jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
        jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());
    }

    var methods = {
        destroy : function () {
            jQuery(this).unbind(".maskMoney");

            if (jQuery.browser.msie) {
                this.onpaste = null;
            }
            return this;
        },

        mask : function (value) {
            return this.each(function () {
                var jQuerythis = jQuery(this),
                    decimalSize;
                if (typeof value === "number") {
                    jQuerythis.trigger("mask");
                    decimalSize = jQuery(jQuerythis.val().split(/\D/)).last()[0].length;
                    value = value.toFixed(decimalSize);
                    jQuerythis.val(value);
                }
                return jQuerythis.trigger("mask");
            });
        },

        unmasked : function () {
            return this.map(function () {
                var value = (jQuery(this).val() || "0"),
                    isNegative = value.indexOf("-") !== -1,
                    decimalPart;
                // get the last position of the array that is a number(coercion makes "" to be evaluated as false)
                jQuery(value.split(/\D/).reverse()).each(function (index, element) {
                    if(element) {
                        decimalPart = element;
                        return false;
                   }
                });
                value = value.replace(/\D/g, "");
                value = value.replace(new RegExp(decimalPart + "jQuery"), "." + decimalPart);
                if (isNegative) {
                    value = "-" + value;
                }
                return parseFloat(value);
            });
        },

        init : function (settings) {
            settings = jQuery.extend({
                prefix: "",
                suffix: "",
                affixesStay: true,
                thousands: "",
                decimal: ".",
                precision: 2,
                allowZero: false,
                allowNegative: false
            }, settings);

            return this.each(function () {
                var jQueryinput = jQuery(this),
                    onFocusValue;

                // data-* api
                settings = jQuery.extend(settings, jQueryinput.data());

                function getInputSelection() {
                    var el = jQueryinput.get(0),
                        start = 0,
                        end = 0,
                        normalizedValue,
                        range,
                        textInputRange,
                        len,
                        endRange;

                    if (typeof el.selectionStart === "number" && typeof el.selectionEnd === "number") {
                        start = el.selectionStart;
                        end = el.selectionEnd;
                    } else {
                        range = document.selection.createRange();

                        if (range && range.parentElement() === el) {
                            len = el.value.length;
                            normalizedValue = el.value.replace(/\r\n/g, "\n");

                            // Create a working TextRange that lives only in the input
                            textInputRange = el.createTextRange();
                            textInputRange.moveToBookmark(range.getBookmark());

                            // Check if the start and end of the selection are at the very end
                            // of the input, since moveStart/moveEnd doesn't return what we want
                            // in those cases
                            endRange = el.createTextRange();
                            endRange.collapse(false);

                            if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                                start = end = len;
                            } else {
                                start = -textInputRange.moveStart("character", -len);
                                start += normalizedValue.slice(0, start).split("\n").length - 1;

                                if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                                    end = len;
                                } else {
                                    end = -textInputRange.moveEnd("character", -len);
                                    end += normalizedValue.slice(0, end).split("\n").length - 1;
                                }
                            }
                        }
                    }

                    return {
                        start: start,
                        end: end
                    };
                } // getInputSelection

                function canInputMoreNumbers() {
                    var haventReachedMaxLength = !(jQueryinput.val().length >= jQueryinput.attr("maxlength") && jQueryinput.attr("maxlength") >= 0),
                        selection = getInputSelection(),
                        start = selection.start,
                        end = selection.end,
                        haveNumberSelected = (selection.start !== selection.end && jQueryinput.val().substring(start, end).match(/\d/)) ? true : false,
                        startWithZero = (jQueryinput.val().substring(0, 1) === "0");
                    return haventReachedMaxLength || haveNumberSelected || startWithZero;
                }

                function setCursorPosition(pos) {
                    jQueryinput.each(function (index, elem) {
                        if (elem.setSelectionRange) {
                            elem.focus();
                            elem.setSelectionRange(pos, pos);
                        } else if (elem.createTextRange) {
                            var range = elem.createTextRange();
                            range.collapse(true);
                            range.moveEnd("character", pos);
                            range.moveStart("character", pos);
                            range.select();
                        }
                    });
                }

                function setSymbol(value) {
                    var operator = "";
                    if (value.indexOf("-") > -1) {
                        value = value.replace("-", "");
                        operator = "-";
                    }
                    return operator + settings.prefix + value + settings.suffix;
                }

                function maskValue(value) {
                    var negative = (value.indexOf("-") > -1 && settings.allowNegative) ? "-" : "",
                        onlyNumbers = value.replace(/[^0-9]/g, ""),
                        integerPart = onlyNumbers.slice(0, onlyNumbers.length - settings.precision),
                        newValue,
                        decimalPart,
                        leadingZeros;

                    // remove initial zeros
                    integerPart = integerPart.replace(/^0*/g, "");
                    // put settings.thousands every 3 chars
                    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, settings.thousands);
                    if (integerPart === "") {
                        integerPart = "0";
                    }
                    newValue = negative + integerPart;

                    if (settings.precision > 0) {
                        decimalPart = onlyNumbers.slice(onlyNumbers.length - settings.precision);
                        leadingZeros = new Array((settings.precision + 1) - decimalPart.length).join(0);
                        newValue += settings.decimal + leadingZeros + decimalPart;
                    }
                    return setSymbol(newValue);
                }

                function maskAndPosition(startPos) {
                    var originalLen = jQueryinput.val().length,
                        newLen;
                    jQueryinput.val(maskValue(jQueryinput.val()));
                    newLen = jQueryinput.val().length;
                    startPos = startPos - (originalLen - newLen);
                    setCursorPosition(startPos);
                }

                function mask() {
                    var value = jQueryinput.val();
                    jQueryinput.val(maskValue(value));
                }

                function changeSign() {
                    var inputValue = jQueryinput.val();
                    if (settings.allowNegative) {
                        if (inputValue !== "" && inputValue.charAt(0) === "-") {
                            return inputValue.replace("-", "");
                        } else {
                            return "-" + inputValue;
                        }
                    } else {
                        return inputValue;
                    }
                }

                function preventDefault(e) {
                    if (e.preventDefault) { //standard browsers
                        e.preventDefault();
                    } else { // old internet explorer
                        e.returnValue = false;
                    }
                }

                function keypressEvent(e) {
                    e = e || window.event;
                    var key = e.which || e.charCode || e.keyCode,
                        keyPressedChar,
                        selection,
                        startPos,
                        endPos,
                        value;
                    //added to handle an IE "special" event
                    if (key === undefined) {
                        return false;
                    }

                    // any key except the numbers 0-9
                    if (key < 48 || key > 57) {
                        // -(minus) key
                        if (key === 45) {
                            jQueryinput.val(changeSign());
                            return false;
                        // +(plus) key
                        } else if (key === 43) {
                            jQueryinput.val(jQueryinput.val().replace("-", ""));
                            return false;
                        // enter key or tab key
                        } else if (key === 13 || key === 9) {
                            return true;
                        } else if (jQuery.browser.mozilla && (key === 37 || key === 39) && e.charCode === 0) {
                            // needed for left arrow key or right arrow key with firefox
                            // the charCode part is to avoid allowing "%"(e.charCode 0, e.keyCode 37)
                            return true;
                        } else { // any other key with keycode less than 48 and greater than 57
                            preventDefault(e);
                            return true;
                        }
                    } else if (!canInputMoreNumbers()) {
                        return false;
                    } else {
                        preventDefault(e);

                        keyPressedChar = String.fromCharCode(key);
                        selection = getInputSelection();
                        startPos = selection.start;
                        endPos = selection.end;
                        value = jQueryinput.val();
                        jQueryinput.val(value.substring(0, startPos) + keyPressedChar + value.substring(endPos, value.length));
                        maskAndPosition(startPos + 1);
                        return false;
                    }
                }

                function keydownEvent(e) {
                    e = e || window.event;
                    var key = e.which || e.charCode || e.keyCode,
                        selection,
                        startPos,
                        endPos,
                        value,
                        lastNumber;
                    //needed to handle an IE "special" event
                    if (key === undefined) {
                        return false;
                    }

                    selection = getInputSelection();
                    startPos = selection.start;
                    endPos = selection.end;

                    if (key === 8 || key === 46 || key === 63272) { // backspace or delete key (with special case for safari)
                        preventDefault(e);

                        value = jQueryinput.val();
                        // not a selection
                        if (startPos === endPos) {
                            // backspace
                            if (key === 8) {
                                if (settings.suffix === "") {
                                    startPos -= 1;
                                } else {
                                    // needed to find the position of the last number to be erased
                                    lastNumber = value.split("").reverse().join("").search(/\d/);
                                    startPos = value.length - lastNumber - 1;
                                    endPos = startPos + 1;
                                }
                            //delete
                            } else {
                                endPos += 1;
                            }
                        }

                        jQueryinput.val(value.substring(0, startPos) + value.substring(endPos, value.length));

                        maskAndPosition(startPos);
                        return false;
                    } else if (key === 9) { // tab key
                        return true;
                    } else { // any other key
                        return true;
                    }
                }

                function focusEvent() {
                    onFocusValue = jQueryinput.val();
                    mask();
                    var input = jQueryinput.get(0),
                        textRange;
                    if (input.createTextRange) {
                        textRange = input.createTextRange();
                        textRange.collapse(false); // set the cursor at the end of the input
                        textRange.select();
                    }
                }

                function cutPasteEvent() {
                    setTimeout(function() {
                        mask();
                    }, 0);
                }

                function getDefaultMask() {
                    var n = parseFloat("0") / Math.pow(10, settings.precision);
                    return (n.toFixed(settings.precision)).replace(new RegExp("\\.", "g"), settings.decimal);
                }

                function blurEvent(e) {
                    if (jQuery.browser.msie) {
                        keypressEvent(e);
                    }

                    if (jQueryinput.val() === "" || jQueryinput.val() === setSymbol(getDefaultMask())) {
                        if (!settings.allowZero) {
                            jQueryinput.val("");
                        } else if (!settings.affixesStay) {
                            jQueryinput.val(getDefaultMask());
                        } else {
                            jQueryinput.val(setSymbol(getDefaultMask()));
                        }
                    } else {
                        if (!settings.affixesStay) {
                            var newValue = jQueryinput.val().replace(settings.prefix, "").replace(settings.suffix, "");
                            jQueryinput.val(newValue);
                        }
                    }
                    if (jQueryinput.val() !== onFocusValue) {
                        jQueryinput.change();
                    }
                }

                function clickEvent() {
                    var input = jQueryinput.get(0),
                        length;
                    if (input.setSelectionRange) {
                        length = jQueryinput.val().length;
                        input.setSelectionRange(length, length);
                    } else {
                        jQueryinput.val(jQueryinput.val());
                    }
                }

                jQueryinput.unbind(".maskMoney");
                jQueryinput.bind("keypress.maskMoney", keypressEvent);
                jQueryinput.bind("keydown.maskMoney", keydownEvent);
                jQueryinput.bind("blur.maskMoney", blurEvent);
                jQueryinput.bind("focus.maskMoney", focusEvent);
                jQueryinput.bind("click.maskMoney", clickEvent);
                jQueryinput.bind("cut.maskMoney", cutPasteEvent);
                jQueryinput.bind("paste.maskMoney", cutPasteEvent);
                jQueryinput.bind("mask.maskMoney", mask);
            });
        }
    };

    jQuery.fn.maskMoney = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === "object" || ! method) {
            return methods.init.apply(this, arguments);
        } else {
            jQuery.error("Method " +  method + " does not exist on jQuery.maskMoney");
        }
    };
})(window.jQuery || window.Zepto);
