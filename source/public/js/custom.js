// JavaScript Document
$(document).ready(function () {
    /**
     * Arrow click event handler of the materials grid for download and upload
     */
    $(".window-arrow-icon").click(function () {
        $(".window-arrow").toggleClass("more-material2");
        $(".more", this).toggle()
        $(".less", this).toggle()
    });

    /**
     * Advance search stop buttion click event handler
     */
    $('#but-stop-click').click(function () {
        $('.dropdown-custom').toggle();
    });

    /**
     * Advance search close button click event handler
     */
    $('#close-advance-search').click(function () {
        $('.dropdown-custom').hide();
    });

    /**
     *  Extending jQuery datatable error
     *
     */

    if($('table').length && $('table').hasClass('gridtable'))
    {
       $.fn.dataTable.ext.errMode = 'none';
    }

    /**
     * Change Shcool Logo
     */
    jQuery(document).on('change', '#school_logo', function () {
        var input = jQuery(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        jQuery('.selected-pic').remove();
        jQuery('#logoname').closest('label').after('<span class="selected-pic"  style="padding-left: 10px;">' + label + '</span>');
    });

    /**
     * For Change User Profile
     */
    jQuery(document).on('change', '#user_profile', function () {
        var input = jQuery(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        jQuery('.selected-pic').remove();
        jQuery('#user_profile').closest('label').after('<span class="selected-pic" style="padding-left: 10px;">' + label + '</span>');
    });

    /**
     * Click Event Handler Of View Incoming Screen Share Request
     */
    jQuery("#btnviewscreen").click(function(){
        var linkurl = jQuery(this).attr('data-url');
        var sharingWindow = window.open(linkurl,'_blank');
        //closeWindow(sharingWindow);
        jQuery('#incomingScreenShare').modal('toggle');
    });

    /**
     * Update user activity on users activity trackers, will call on
     * browser event via ajax (firefox does not support)
     * @param e
     * @returns {null}
     */
    window.onbeforeunload = function(e) {

        $.get("/update-auth-activity");
        return null; // not working on FIrefox
    }

    jQuery(document).on('click',"#reject_incoming_share_request",function(){
        jQuery('#incomingScreenShare').modal('hide');
    });
});

(function ($) {

    'use strict';
    /**
     * Responsive Tab of the Teacher materials grid
     */
    $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function (e) {
        var $target  = $(e.target);
        var $tabs    = $target.closest('.nav-tabs-responsive');
        var $current = $target.closest('li');
        var $parent  = $current.closest('li.dropdown');
        $current     = $parent.length > 0 ? $parent : $current;
        var $next    = $current.next();
        var $prev    = $current.prev();
        var updateDropdownMenu = function ($el, position) {
            $el
                .find('.dropdown-menu')
                .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                .addClass('pull-xs-' + position);
        };

        $tabs.find('>li').removeClass('next prev');
        $prev.addClass('prev');
        $next.addClass('next');

        updateDropdownMenu($prev, 'left');
        updateDropdownMenu($current, 'center');
        updateDropdownMenu($next, 'right');
    });

})(jQuery);

/**
 * This function is used to make string short with 3 dots (...)
 * Basically used in portal and school admin linting pages
 * @param string
 * @param limit
 */
function getLimitedString(string,limit) {
    screenWidth =  jQuery( window ).width();
        if (string) {
            // if device is not desktop
            if(screenWidth <= 991) {
                if (!limit) {
                    limit = 25;
                }
                if (string.length > limit) {
                    string = string.substr(0, limit) + "...";
                }
            }
         return string;
    }
}

/**
 * This function is used for the Selected File Name
 * @param input
 */
function showSelectedFileName(input) {
    var input = jQuery(input),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    var inputId = jQuery(input).attr('id');
    jQuery('.selected-pic_'+inputId).remove();
    jQuery('#'+inputId).closest('label').after('<span class="selected-pic_'+inputId+'" style="padding-left: 10px;">' + label + '</span>');
}

/**
 * Open join.me app when get screen share request
 * @param sharedUrl
 * @returns {boolean}
 * Called from student's dashboard
 */
function shareScreen(sharedUrl, isViewer) {

    if(sharedUrl === '')
    {
        return false;
    }

    var linkurl = sharedUrl;
        var sharingWindow = window.open(linkurl,'_blank');
        if(isViewer == 'false') {
            closeWindow(sharingWindow);
        }

       jQuery('#incomingScreenShare').modal('toggle');
}

/**
 * This function basically use to close join me window after join me app gets ready
 * @param openedWindowObj
 * @param duration
 */
function closeWindow(openedWindowObj, duration)
{
    if(!duration)
    {
        duration = 10000; // 10 seconds
    }
    setTimeout(function(){
        openedWindowObj.close();
    }, duration);
}


function destroypopupbox(openedWindowObj){
    var duration = 10000;
    setTimeout(function(){
        var objiframe = openedWindowObj.contents().find("iframe");
        objiframe.find('#meetingEndCap').remove();
        console.log('HEre');
    }, duration);
}