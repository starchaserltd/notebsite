var pause_presearch = 1;
var cur_advss = "";
var cur_sss = "";
var cur_qss = "";

var presearch_modal_timeout = 0;

// DOM ELEMENTS
var presearch_modal, presearch_modal_counter, presearch_modal_close;
var adv_presearch_modal, adv_presearch_modal_counter, adv_presearch_modal_close;

// SET DOM ELEMENTS
function getPreserachElements() {
  presearch_modal = document.getElementById("presearch-modal");
  presearch_modal_counter = document.getElementById("presearch-modal-counter");
  presearch_modal_close = document.getElementById("presearch-modal-close");

  $(window).on("scroll", function() {
    setModalTop("sidebar");
  })
}

function getAdvPreserachElements() {
  adv_presearch_modal = document.getElementById("adv-presearch-modal");
  adv_presearch_modal_counter = document.getElementById(
    "adv-presearch-modal-counter"
  );
  adv_presearch_modal_close = document.getElementById(
    "adv-presearch-modal-close"
  );

  // $(window).on("scroll", function() {
  //   setModalTop("advanced");
  // })
}


var contentElement = document.querySelector(".row.containerContentIndex");
var contentOffset = 0;
function getContentOffset() {
  if (contentElement) {
    contentOffset = contentElement.offsetTop;
  }
}
$(window).on("scroll", getContentOffset);

function setModalTop(type) {
  var modal = getModal(type);

  if (document.documentElement.scrollTop <= contentOffset) {
    modal.style.top = '10px';

  } else {
    var windowOffset = document.documentElement.scrollTop;
    modal.style.top = `${10 + windowOffset - contentOffset}px`
  }
}
// Set on scroll function handlers on get modal function;


// SELECTING
function getModal(type) {
  return type === "advanced" ? adv_presearch_modal : presearch_modal;
}
function getCounter(type) {
  return type === "advanced"
    ? adv_presearch_modal_counter
    : presearch_modal_counter;
}
function getClose(type) {
  return type === "advanced"
    ? adv_presearch_modal_close
    : presearch_modal_close;
}

setTimeout(function () {
  pause_presearch = 0;
}, 2000);

// SIDEBAR PRESEARCH
function displayPresearchModal(type) {
  var modal = getModal(type);

  if (!modal.classList.contains("show")) {
    modal.classList.add("show");
  }
}

function hidePresearchModal(type) {
  var modal = getModal(type);

  if (modal.classList.contains("show")) {
    modal.classList.remove("show");
  }
}

function handlePresearchModal(searchCount, type) {
  if (type === "sidebar") {
    getPreserachElements();
  }
  if (type === "advanced") {
    getAdvPreserachElements();
  }

  presearch_modal_timeout = 3000;

  var modal = getModal(type);
  var counter = getCounter(type);
  var close = getClose(type);

  counter.innerHTML = `${searchCount}`;
  close.onclick = function () {
    hidePresearchModal(type);
  };

  // Start the watcher
  if (!modal.classList.contains("show")) {
    var interval = setInterval(function () {
      if (presearch_modal_timeout <= 0) {
        hidePresearchModal(type);
        clearInterval(interval);
      }

      presearch_modal_timeout -= 100;
    }, 100);
    displayPresearchModal(type);
  }
}

function presearch(formname) {
  var do_presearch = 0;
  var sstring = "";
  switch (formname) {
    case "#advform": {
      var sstring = $(formname).serialize();
      if (cur_advss != sstring) {
        cur_advss = sstring;
        do_presearch = 1;
      }
      break;
    }
    case "#s_search": {
      var sstring = $(formname).serialize();
      if (cur_sss != sstring) {
        cur_sss = sstring;
        do_presearch = 1;
      }
      break;
    }
    case "quiz": {
      var tosearch = "b";
      quiz_submit = [];
      i = 0;
      for (var key1 in quiz) {
        var opt = quiz[key1]["options"];
        for (var key2 in opt) {
          var selected = opt[key2];
          if (
            typeof selected["chk"] != "undefined" &&
            selected["chk"]["on"] == 1 &&
            selected["no"] > 0 &&
            key1 != 4 &&
            key1 != 5
          ) {
            quiz_submit[i] = key2 + "=1";
            i++;
          }
        }
      }
      if (i > 0) {
        var sstring = "quizsearch=1&" + quiz_submit.join("&");
        if (cur_qss != sstring) {
          cur_qss = sstring;
          do_presearch = 1;
        }
      }
      break;
    }
  }

  if (do_presearch && pause_presearch != 1 && sstring != "") {
    pause_presearch = 1;
    setTimeout(function () {
      if (formname === "") {
        return;
      } else {
        if (window.XMLHttpRequest) {
          var xmlhttp = new XMLHttpRequest();
        }

        xmlhttp.onreadystatechange = function () {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var [, searchCount] = xmlhttp.responseText.split("+++++");

            // Set the presearch type to be handeled by the controller
            var presearch_type = undefined;
            switch (formname) {
              case "#s_search":
                presearch_type = "sidebar";
                break;
              case "#advform":
                presearch_type = "advanced";
                break;
            }
            if (presearch_type !== undefined) {
              handlePresearchModal(searchCount, presearch_type);
            }
          }
        };
        if (formname != "quiz") {
          xmlhttp.open("GET", "search/search.php?presearch=1&" + sstring, true);
        } else {
          xmlhttp.open(
            "GET",
            nquiz + "search/qsearch.php?p=1&presearch=1&" + sstring,
            true
          );
        }
        xmlhttp.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        xmlhttp.send();
      }
      pause_presearch = 0;
    }, 250);
  }
}
