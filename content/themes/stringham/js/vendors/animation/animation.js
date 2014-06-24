/* ========================================================================
 * Bootstrap: modal.js v3.1.1 Revised by DazeinCreative
 * http://getbootstrap.com/javascript/#modals
 * http://themeforest.net/user/DazeinCreative
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function (jQuery) {
 'use strict';

  // MODAL CLASS DEFINITION
  // ======================

  var Modal = function (element, options) {
    this.options   = options
    this.jQueryelement  = jQuery(element)
    this.jQuerybackdrop =
    this.isShown   = null

    if (this.options.remote) {
      this.jQueryelement
        .find('.modal-content')
        .load(this.options.remote, jQuery.proxy(function () {
          this.jQueryelement.trigger('loaded.bs.modal')
        }, this))
    }
  }

  Modal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  }

  Modal.prototype.toggle = function (_relatedTarget) {
    return this[!this.isShown ? 'show' : 'hide'](_relatedTarget)
  }

  Modal.prototype.show = function (_relatedTarget) {
    var that = this
    var e    = jQuery.Event('show.bs.modal', { relatedTarget: _relatedTarget })

    this.jQueryelement.trigger(e)

    if (this.isShown || e.isDefaultPrevented()) return

    this.isShown = true

    this.escape()

    this.jQueryelement.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', jQuery.proxy(this.hide, this))

    this.backdrop(function () {
      // var transition = jQuery.support.transition && that.jQueryelement.hasClass('fade')
      var transition = jQuery.support.transition && that.jQueryelement.hasClass(that.options.easein);

      if (!that.jQueryelement.parent().length) {
        that.jQueryelement.appendTo(document.body) // don't move modals dom position
      }

      that.jQueryelement
        .show()
        .scrollTop(0)

      if (transition) {
        that.jQueryelement[0].offsetWidth // force reflow
      }

      that.jQueryelement
        // .addClass('in')
        .removeClass(that.options.easeout)
        .addClass('animated' + ' ' + that.options.easein)
        .attr('aria-hidden', false)

      that.enforceFocus()

      var e = jQuery.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

      transition ?
        that.jQueryelement.find('.modal-dialog') // wait for modal to slide in
          .one(jQuery.support.transition.end, function () {
            that.jQueryelement.focus().trigger(e)
          })
          .emulateTransitionEnd(300) :
        that.jQueryelement.focus().trigger(e)
    })
  }
function eventsList(element) {
            // JQuery Versions compartibility
			var events;
           // events = element.data('events');
            //if (events !== undefined) return events;

            events = jQuery.data(element, 'events');
            if (events !== undefined) return true;

            events = jQuery._data(element, 'events');
            if (events !== undefined) return true;

           // events = jQuery._data(element[0], 'events');
           // if (events !== undefined) return events;

            return false;
        }
  	function getEventType(e) {
2
    if (!e) e = window.event;
3
    alert(e.type);
4
}

  Modal.prototype.hide = function (e) {

  	if ({}.toString.call(e).slice(8,-1)=="HTMLAnchorElement") return
if (e) e.preventDefault()
	
    e = jQuery.Event('hide.bs.modal')

    this.jQueryelement.trigger(e)

    if (!this.isShown || e.isDefaultPrevented()) return

    this.isShown = false

    this.escape()

    jQuery(document).off('focusin.bs.modal')
    this.jQueryelement
      .removeClass('in ' + this.options.easein)
      .addClass('' + ' ' + this.options.easeout)
      .attr('aria-hidden', true)
      .off('click.dismiss.bs.modal')

    jQuery.support.transition?
      this.jQueryelement
        .one(jQuery.support.transition.end, jQuery.proxy(this.hideModal, this))
        .emulateTransitionEnd(300) :
      this.hideModal()
  }

  Modal.prototype.enforceFocus = function () {
    jQuery(document)
      .off('focusin.bs.modal') // guard against infinite focus loop
      .on('focusin.bs.modal', jQuery.proxy(function (e) {
        if (this.jQueryelement[0] !== e.target && !this.jQueryelement.has(e.target).length) {
          this.jQueryelement.focus()
        }
      }, this))
  }

  Modal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.jQueryelement.on('keyup.dismiss.bs.modal', jQuery.proxy(function (e) {
        e.which == 27 && this.hide()
      }, this))
    } else if (!this.isShown) {
      this.jQueryelement.off('keyup.dismiss.bs.modal')
    }
  }

  Modal.prototype.hideModal = function () {
    var that = this
    this.jQueryelement.hide()
    this.backdrop(function () {
      that.removeBackdrop()
      that.jQueryelement.trigger('hidden.bs.modal')
    })
  }

  Modal.prototype.removeBackdrop = function () {
    this.jQuerybackdrop && this.jQuerybackdrop.remove()
    this.jQuerybackdrop = null
  }

  Modal.prototype.backdrop = function (callback) {
    var animate = this.jQueryelement.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = jQuery.support.transition && animate

      this.jQuerybackdrop = jQuery('<div class="modal-backdrop ' + animate + '" />')
        .appendTo(document.body)

      this.jQueryelement.on('click.dismiss.bs.modal', jQuery.proxy(function (e) {
        if (e.target !== e.currentTarget) return
        this.options.backdrop == 'static'
          ? this.jQueryelement[0].focus.call(this.jQueryelement[0])
          : this.hide.call(this)
      }, this))

      if (doAnimate) this.jQuerybackdrop[0].offsetWidth // force reflow

      this.jQuerybackdrop.addClass('in')

      if (!callback) return

      doAnimate ?
        this.jQuerybackdrop
          .one(jQuery.support.transition.end, callback)
          .emulateTransitionEnd(150) :
        callback()

    } else if (!this.isShown && this.jQuerybackdrop) {
      this.jQuerybackdrop.removeClass('in')

      jQuery.support.transition && this.jQueryelement.hasClass('fade') ?
        this.jQuerybackdrop
          .one(jQuery.support.transition.end, callback)
          .emulateTransitionEnd(150) :
        callback()

    } else if (callback) {
      callback()
    }
  }


  // MODAL PLUGIN DEFINITION
  // =======================

  var old = jQuery.fn.modal

  jQuery.fn.modal = function (option, _relatedTarget) {
    return this.each(function () {
      var jQuerythis   = jQuery(this)
      var data    = jQuerythis.data('bs.modal')
      var options = jQuery.extend({}, Modal.DEFAULTS, jQuerythis.data(), typeof option == 'object' && option)

      if (!data) jQuerythis.data('bs.modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option](_relatedTarget)
      else if (options.show) data.show(_relatedTarget)
    })
  }

  jQuery.fn.modal.Constructor = Modal


  // MODAL NO CONFLICT
  // =================

  jQuery.fn.modal.noConflict = function () {
    jQuery.fn.modal = old
    return this
  }


  // MODAL DATA-API
  // ==============

  jQuery(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
    var jQuerythis   = jQuery(this)
    var href    = jQuerythis.attr('href')
    var jQuerytarget = jQuery(jQuerythis.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+jQuery)/, ''))) //strip for ie7
    var option  = jQuerytarget.data('bs.modal') ? 'toggle' : jQuery.extend({ remote: !/#/.test(href) && href }, jQuerytarget.data(), jQuerythis.data())

    if (jQuerythis.is('a')) e.preventDefault()

    jQuerytarget
      .modal(option, this)
      .one('hide', function () {
        jQuerythis.is(':visible') && jQuerythis.focus()
      })
  })

  jQuery(document)
    .on('show.bs.modal', '.modal', function () { jQuery(document.body).addClass('modal-open') })
    .on('hidden.bs.modal', '.modal', function () { jQuery(document.body).removeClass('modal-open') })

}(jQuery);

jQuery(function() {

    // the global default ease in animation of the tab and popover
    var _easeIn = 'fadeInLeft';
    var _previewTabContent;
    var _previeweaseIn;

    enhanceTab(jQuery('#myTab1 a'), jQuery('#tab-content1'));
    // enhanceTab(jQuery('#myTab2 a'), jQuery('#tab-content2'));

    // add the animation to the tab
    function enhanceTab(tab, tabContent, easein){
      tab.click(function (e) {
          e.preventDefault();
          jQuery(this).tab('show');
          var _existeaseIn = jQuery(this).data('easein');
          if(_previewTabContent) _previewTabContent.removeClass(_previeweaseIn);
          if(_existeaseIn){
              tabContent.find('div.active').addClass('animated '+ _existeaseIn);
              _previeweaseIn = _existeaseIn;
          }else{
              if(easein){
                tabContent.find('div.active').addClass('animated '+ easein);
                _previeweaseIn = easein;
              }else{
                tabContent.find('div.active').addClass('animated '+ _easeIn);
                _previeweaseIn = _easeIn;
              }
          }
          _previewTabContent = tabContent.find('div.active');
      });

    }

    // add the animation to the popover
    jQuery("a[rel=popover]").popover().click(function(e) {
        e.preventDefault();
        if(jQuery(this).data('easein')!=undefined){
		     jQuery(this).next(".popover").removeClass(jQuery(this).data('easein')).addClass('animated ' + jQuery(this).data('easein'));
        } else{
          jQuery(this).next(".popover").addClass('animated ' + _easeIn);
        } 
    })
});
