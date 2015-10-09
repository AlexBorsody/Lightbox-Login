/**
 *globals Drupal, jQuery, window
 */

/**
 *jslint plusplus: true, sloppy: true, white: true
 */

(function ($, Drupal, window) {

  "use strict";

  var popupVisible, ctrlPressed, lightboxLoginBox, messageContainer;

  popupVisible = false;
  ctrlPressed = false;

  function moveMessages() {
    var messages = $("#lightbox_login_login_box .messages");

    if (messages.length) {
      if (!messageContainer) {
        messageContainer = $("<div/>", {id:"lightbox_login_messages_container_wrapper"}).prependTo("body");
      }
      messages.each(function () {
        $(this).appendTo(
          $("<div/>", {"class":"lightbox_login_messages_container"}).appendTo(messageContainer)
        ).before(
          $("<div/>", {"class":"lightbox_login_message_close_button"}).text("X")
        );
      });
    }
  }

  function showLogin() {
    var settings = drupalSettings.lightbox_login.lightboxLogin;

    if (!popupVisible) {
      popupVisible = true;
      if (settings.hideObjects) {
        $("object, embed").css("visibility", "hidden");
      }
      $("#lightbox_login_dim_screen").css({backgroundColor:settings.screenFadeColor, zIndex:settings.screenFadeZIndex, opacity:0, display:"block"}).fadeTo(settings.dimFadeSpeed, 0.8, function () {
        var eHeight, eWidth, eTopMargin, eLeftMargin;

        eHeight = lightboxLoginBox.height();
        eWidth = lightboxLoginBox.width();
        eTopMargin = - 1 * (eHeight / 2);
        eLeftMargin = -1 * (eWidth / 2);

        if ($("#lightbox_login_close_button").css("display") === "none") {
          $("#lightbox_login_close_button").css("display", "block");
        }

        lightboxLoginBox.css({marginLeft:eLeftMargin, marginTop:eTopMargin, color:settings.loginBoxTextColor, backgroundColor:settings.loginBoxBackgroundColor, borderStyle:settings.loginBoxBorderStyle, borderColor:settings.loginBoxBorderColor, borderWidth:settings.loginBoxBorderWidth, zIndex:(settings.screenFadeZIndex + 1)}).fadeIn(settings.boxFadeSpeed).find(".form-text:first").focus().select();
      });
    }
  }

  function hideLogin() {
    var settings = drupalSettings.lightbox_login.lightboxLogin;

    if (popupVisible) {
      popupVisible = false;
      $("#lightbox_login_login_box").fadeOut(settings.boxFadeSpeed, function () {
        $("#lightbox_login_dim_screen").fadeOut(settings.dimFadeSpeed, function () {
          if (settings.hideObjects) {
            $("object, embed").css("visibility", "visible");
          }
        });
        $(window).focus();
      });
    }
  }

  function popupCloseListener() {
    $("#lightbox_login_dim_screen, #lightbox_login_close_button").once("fancy-login-close-listener", function () {
      $(this).click(function (e) {
        e.preventDefault();
        hideLogin();
      });
    });
  }

  function statusMessageCloseListener() {
    $(".lightbox_login_message_close_button").once("status-message-close-listener", function () {
      $(this).click(function () {
        $(this).parent().fadeOut(250, function () {
          $(this).remove();
        });
      });
    });
  }

  function loginLinkListener() {
    var settings = drupalSettings.lightbox_login.lightboxLogin;

    $("a[href*='" + settings.loginPath + "']:not(.lightbox_login_disable), .lightbox_login_show_popup:not(.lightbox_login_disable)").once("login-link-listener", function () {
      $(this).click(function (e) {
        e.preventDefault();
        showLogin();
      });
    });
  }

  function init() {
    $("body").once("fancy-login-init", function () {
      lightboxLoginBox = $("#lightbox_login_login_box");
      $(window.document).keyup(function (e) {
        if (e.keyCode === 17) {
          ctrlPressed = false;
        }
        else if (e.keyCode === 27) {
          hideLogin();
        }
      });
      $(window.document).keydown(function(e) {
        if (e.keyCode === 17) {
          ctrlPressed = true;
        }
        if (ctrlPressed === true && e.keyCode === 190) {
          ctrlPressed = false;

          if (popupVisible) {
            hideLogin();
          }
          else {
            showLogin();
          }
        }
      });
    });
  }

  function popupTextfieldListener() {
    lightboxLoginBox.find(".form-text").once("fancy-login-popup-textfield-listener", function () {
      $(this).keydown(function (event) {
        if (event.keyCode === 13) {
          $(this).parent().siblings(".form-actions:first").children(".form-submit:first").mousedown();
        }
      });
    });
  }

  function loadForm(type) {
    var formLoadDimmer = $("<div/>", {"id":"form_load_dimmer"}).appendTo(lightboxLoginBox).fadeTo(250, 0.8);

    $.ajax({
      url:drupalSettings.path.baseUrl + "lightbox_login/ajax/" + type,
      success:function(data) {
        var wrapper, oldContents, newContents, oldHeight, newHeight, newMargin;

        wrapper = lightboxLoginBox.find("#lightbox_login_user_login_block_wrapper");
        oldContents = wrapper.contents();
        oldHeight = wrapper.css("height");
        newContents = $("<div/>").html(data.content).contents();
        $("#lightbox_login_user_login_block_wrapper").html(data.content);
        newHeight = wrapper.css("height");
        newMargin = lightboxLoginBox.outerHeight() / -2;
        $("#lightbox_login_user_login_block_wrapper").html('');
        wrapper.css("height", oldHeight);
        oldContents.fadeOut(250, function () {
          $(this).remove();
          lightboxLoginBox.animate({
            marginTop:newMargin
          },
          {
            duration:250
          });
          wrapper.animate({
            height:newHeight
          },
          {
            duration:250,
            complete:function () {
              newContents.appendTo(wrapper).fadeIn(250, function () {
                wrapper.css("height", "auto");
                formLoadDimmer.fadeOut(250, function () {
                  $(this).remove();
                });
              });
              Drupal.attachBehaviors();
            }
          });
        });
      }
    });
  }

  function linkListeners() {
    var anchors = lightboxLoginBox.find("a");

    anchors.filter("[href*='user/password']").once("fancy-login-password-link", function () {
      $(this).click(function (e) {
        e.preventDefault();
        loadForm("password");
      });
    });

    anchors.filter("[href*='user/login']").once("fancy-login-login-link", function () {
      $(this).click(function (e) {
        e.preventDefault();
        loadForm("login");
      });
    });
  }

  Drupal.behaviors.lightboxLogin = {
    attach:function () {
      if (window.XMLHttpRequest) {
        init();
        loginLinkListener();
        popupTextfieldListener();
        popupCloseListener();
        statusMessageCloseListener();
        moveMessages();
        linkListeners();
      }

      Drupal.AjaxCommands.prototype.lightboxLoginRefreshPage = function(ajax, response) {
        if (response.closePopup) {
          hideLogin();
        }
        window.location.reload();
      };

      Drupal.AjaxCommands.prototype.lightboxLoginRedirect = function(ajax, response) {
        if (response.closePopup) {
          hideLogin();
        }

        if (response.destination.length) {
          window.location = response.destination;
        }
        else {
          window.location = "/user";
        }
      };
      
      Drupal.AjaxCommands.prototype.lightboxLoginClosePopup = function () {
        hideLogin();
      };
    }
  };

}(jQuery, Drupal, window));