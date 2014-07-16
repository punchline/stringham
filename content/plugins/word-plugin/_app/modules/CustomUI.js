define(
[
    './UI',
    'text!../assets/template/custom-template.html',
    'i18n!../nls/wordsearch',
    './Utils',
    'underscore'
],

function(UI, tmpl, locale, $) {
    'use strict';
    
    var template = _.template(tmpl);

    function CustomUI(options) {
        
        var div  = document.createElement("div"),
            fragment = document.createDocumentFragment();
        div.innerHTML = template({_: locale, uid: options.uid});
        div.className = "wordsearch";

        var oldContainer = document.getElementById(options.container) || document.body;

        if (options.container && typeof(options.container) !== "string")
            oldContainer = options.container;

        if (oldContainer === document.body)
            oldContainer.innerHTML = "";

        $.addClass(oldContainer, "wordsearch");


        oldContainer.parentNode.insertBefore(div, oldContainer);
        div.parentNode.removeChild(oldContainer);
        
        options.container = 'soup-'+options.uid;
        options.oldContainer = div;
        
        UI.call(this, options);
    }
    
    CustomUI.prototype = UI.prototype; 
    
    return CustomUI;
});
