var isCheckUnload = true;

function OnBeforeUnload() {
    if (isCheckUnload) window.event.returnValue = strBeforeUnload;
}

function eventByTimeout(event, timeout) {
    if (timeout > 0)
        window.setTimeout(event, timeout * 1000);
}

/*
 function openWindow(url, windName) {
 isCheckUnload = false;
 var w = window.open(url, windName, 'height=400,width=390,status=yes,dependent=no,scrollbars=yes,resizable=no');
 isCheckUnload = true;
 return false;
 }*/

function openWindow(url, windName, lang) {
    isCheckUnload = false;
    if (lang && lang.length === 2) {
        if (url.indexOf("?") > 0) url = url + "&language=" + lang;
        else url = url + "?language=" + lang;
    }
    window.open(url, windName, 'height=390,width=450,dependent=no,toolbar=0,location=0,directories=0,status=0,address=0,menubar=0,scrollbars=0,resizable=0');
    isCheckUnload = true;
    return false;
}

function closeWindow() {
    isCheckUnload = false;
    window.close();
}

function getInt(str, def) {
    if (str == "" || str.substr(0, 1) === "%") return def;
    return parseInt(str);
}

function getBool(str, def) {
    if (str == "" || str.substr(0, 1) === "%") return def;
    return (str == "true");
}

function ValidatePassword(pwd, minLen, maxLen, alphaNum) {
    var pwdLength = pwd.length;
    if (pwdLength < minLen || pwdLength > maxLen)
        return false;

    if (alphaNum == true) {
        var l = 0, d = 0;
        for (i = 0; i < pwdLength; i++) {
            var c = pwd.substr(i, 1);
            if (c.toUpperCase() !== c.toLowerCase()) l++;
            else if ('0' <= c && c <= '9') d++;
        }
        return (d > 0 && l > 0);
    }

    return true;
}
