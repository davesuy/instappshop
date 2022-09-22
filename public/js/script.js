/******/ (() => {
  // webpackBootstrap
  /******/ var __webpack_modules__ = {
    /***/ "./resources/js/script.js":
      /*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
      /***/ function() {
        var _this = this;

        (function() {
          var link = document.createElement("link"),
            cUrl = "https://app.suud.app";
          link.rel = "stylesheet";
          link.href = "".concat(cUrl, "/css/style.css");
          link.async = true;
          document.getElementsByTagName("head")[0].appendChild(link);

          var IDGenerator = function IDGenerator() {
            _this.length = 8;
            _this.timestamp = +new Date();

            var _getRandomInt = function _getRandomInt(min, max) {
              return Math.floor(Math.random() * (max - min + 1)) + min;
            };

            _this.generate = function() {
              var ts = _this.timestamp.toString();

              var parts = ts.split("").reverse();
              var id = "";

              for (var i = 0; i < _this.length; ++i) {
                var index = _getRandomInt(0, parts.length - 1);

                id += parts[index];
              }

              return id;
            };
          };

          console.log("working");

          var loadScript = function loadScript(urls, callback) {
            urls.forEach(function(url, idx, array) {
              var script = document.createElement("script");
              script.type = "text/javascript"; // If the browser is Internet Explorer.

              if (script.readyState) {
                script.onreadystatechange = function() {
                  if (
                    script.readyState == "loaded" ||
                    script.readyState == "complete"
                  ) {
                    script.onreadystatechange = null;

                    if (idx === array.length - 1) {
                      callback();
                    }
                  }
                }; // For any other browser.
              } else {
                script.onload = function() {
                  if (idx === array.length - 1) {
                    callback();
                  }
                };
              }

              script.src = url;
              document.getElementsByTagName("head")[0].appendChild(script);
            });
          };

          function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
          }

          function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(";");

            for (var i = 0; i < ca.length; i++) {
              var c = ca[i];

              while (c.charAt(0) == " ") {
                c = c.substring(1);
              }

              if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
              }
            }

            return "";
          }

          var NotifyScript = function NotifyScript(jQuery) {
            console.log(jQuery);
            var scrore = 0,
              prevRun = false;

            var cookieKey = "prev_order",
              createOrder = function createOrder(data, plan_id, callback) {
                jQuery.ajax({
                  url: "".concat(cUrl, "/tienda/").concat(LS.store.id),
                  type: "post",
                  dataType: "json",
                  data: {
                    items: data.items,
                    currency: data.currency,
                    plan_id: plan_id,
                    prev_order: Udally.prev_oder,
                  },
                  success: function success(checkout) {
                    updateConverse();

                    if (checkout.invoiceUrl !== undefined && scrore > 0) {
                      jQuery("#udally-checkout").removeClass("mfp-hide");
                      Udally.prev_oder = checkout.id;
                      Udally.invoice = checkout.invoiceUrl;
                      setCookie(cookieKey, Udally.invoice, 60 * 24);
                    }
                  },
                  complete: function complete() {
                    if (scrore < 1) {
                      jQuery("#udally-checkout").addClass("mfp-hide");
                    }

                    if (typeof callback == "function") {
                      callback();
                    }
                  },
                });
              };

            jQuery.ajax({
              url: "".concat(cUrl, "/api/").concat(LS.store.id),
              type: "get",
              dataType: "json",
              data: {
                items: 5,
              },
              success: function success(response) {
                if (response) {
                  var feeds = response.feeds;
                  var feedContianer = '<div class="insta-feed-attcher">'; //create Div Element w/ jquery

                  jQuery.each(feeds, function(index, feed) {
                    if (feed.type == "image") {
                      feedContianer += '<div><img src="'
                        .concat(feed.url, '" alt="')
                        .concat(feed.caption, '"></div>');
                    }
                  });
                  feedContianer += "</div>";
                  instafeedContainer = jQuery("body").find(
                    ".insta-feed-container"
                  ).length
                    ? $(".insta-feed-container")
                    : $("body");
                  instafeedContainer.prepend(jQuery(feedContianer));
                }
              },
            });
          };

          scripts = [];

          if (
            typeof jQuery === "undefined" ||
            parseFloat(jQuery.fn.jquery) < 1.7
          ) {
            scripts.unshift(
              "//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"
            );
          }

          loadScript(scripts, function() {
            jQuery191 = jQuery.noConflict(true);

            if (jQuery == undefined) {
              jQuery = jQuery191;
            }

            NotifyScript(jQuery);
          });
        })();

        /***/
      },

    /******/
  }; // startup // Load entry module and return exports // This entry module is referenced by other modules so it can't be inlined
  /************************************************************************/
  /******/

  /******/ /******/ /******/ /******/ var __webpack_exports__ = {};
  /******/ __webpack_modules__["./resources/js/script.js"]();
  /******/
  /******/
})();
