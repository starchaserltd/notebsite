// GLOBALS
var phpData,
  template,
  templateHidden,
  allTablesShown = false;

template = {
  // id: {
  //   title: string,
  //   data:[ [title, key, hidden?], ...],
  // }
  CPU: {
    title: "Processor",
    data: [
      ["Model", "model"],
      ["Launch Date", "ldate"],
      ["Socket", "socket", true],
      ["Technology", "tech", true],
      ["Cache", "cache", true],
      ["Base Speed", "clocks", true],
      ["Max. Speed", "maxtf"],
      ["Nr. of cores", "cores"],
      ["TDP", "tdp"],
      ["Performance class", "class"],
      ["Miscellaneous", "msc", true],
      ["Rating", "rating"],
    ],
  },
  GPU: {
    title: "Video Card",
    data: [
      ["Model", "model"],
      ["Core Speed", "cspeed"],
      ["Memory speed", "mspeed"],
      ["Memory", "vmem"],
      ["TDP", "power"],
      ["Performance class", "gpuclass"],
      ["Rating", "rating"],
      ["Architecture", "arch", true],
      ["Technology", "tech", true],
      ["Pipelines", "pipe", true],
      ["Shader model", "shader", true],
      ["Memory BUS", "mbw", true],
      ["Shared memory", "sharem", true],
      ["Miscellaneous", "msc", true],
    ],
  },
  DISPLAY: {
    title: "Display",
    data: [
      ["Size", "size"],
      ["Format", "format", true],
      ["Resolution", "resolution"],
      ["Surface type", "surft", true],
      ["Technology", "backt"],
      ["Touchscreen", "touch"],
      ["Miscellaneous", "msc"],
    ],
  },
  STORAGE: {
    title: "Storage",
    data: [
      ["Capacity", "cap"],
      ["RPM", "rpm", true],
      ["Type", "type"],
      ["Read speed", "readspeed"],
      ["Write speed", "writes", true],
      ["Miscellaneous", "msc", true],
    ],
  },
  SSTORAGE: {
    title: "Secondary Storage",
    data: [
      ["Capacity", "cap"],
      ["RPM", "rpm", true],
      ["Type", "type"],
      ["Read speed", "readspeed"],
      ["Write speed", "writes", true],
    ],
  },
  MDB: {
    title: "Motherboard",
    data: [
      ["Memory Slots", "ram", true],
      ["Chipset", "chipset"],
      ["Internal Ports", "hdd", true],
      ["LAN Network", "netw"],
      ["Storage Interfaces", "interface", true],
      ["Miscellaneous", "msc"],
    ],
  },
  MEM: {
    title: "Memory",
    data: [
      ["Capacity", "cap"],
      ["Standard", "stan", true],
      ["Type", "type"],
      ["CAS Latency", "lat", true],
      ["Miscellaneous", "msc", true],
    ],
  },
  ODD: {
    title: "Optical Drive",
    data: [
      ["Type", "type"],
      ["Speed", "speed"],
      ["Miscellaneous", "msc", true],
    ],
  },
  ACUM: {
    title: "Battery",
    data: [
      ["Capacity", "cap"],
      ["Cells type", "tipc"],
      ["Weight", "weight", true],
      ["Miscellaneous", "msc", true],
    ],
  },
  CHASSIS: {
    title: "Chassis",
    data: [
      ["Peripheral Ports", "pi"],
      ["Video Ports", "vi"],
      ["WebCam", "web", true],
      ["Touchpad", "touch", true],
      ["Keyboard", "keyboard", true],
      ["Charger", "charger", true],
      ["Weight", "weight"],
      ["Thickness", "thic", true],
      ["Depth", "depth", true],
      ["Width", "width", true],
      ["Color", "color", true],
      ["Material", "made"],
      ["Miscellaneous", "msc", true],
    ],
  },
  WNET: {
    title: "Wireless",
    data: [
      ["Model", "model"],
      ["Slot", "slot", true],
      ["Speed", "speed"],
      ["Standard", "stand", true],
      ["Miscellaneous", "msc", true],
    ],
  },
  MSC: {
    title: "Other",
    data: [
      ["Warranty Duration", "war_time"],
      ["Warranty Miscellaneous", "war_msc"],
      ["Operating system", "os"],
      ["Miscellaneous", "msc"],
    ],
  },
};
// HELPERS
function hideTable(tableId) {
  var tableName = `${tableId}_table`;
  var tableTitle = `${tableId}_title`;
  var table = document.getElementById(tableName);
  if (!table) {
    return;
  }
  var titleElement = document.getElementById(tableTitle);
  if (!titleElement) {
    console.warn(`No title found for table ${id}.`);
    return;
  }
  var isHidden = templateHidden[tableId];
  var caret = titleElement.querySelector(".fas");
  if (caret) {
    caret.classList.remove("fa-caret-down", "fa-caret-up");
    caret.classList.add(isHidden ? "fa-caret-down" : "fa-caret-up");
  }
  var hideableRows = template[tableId].data.map(function ([
    title,
    key,
    hidden,
  ]) {
    return !!hidden;
  });
  var rows = table.querySelectorAll(`#${tableName} .compare__row`);
  var isOdd = false;
  rows.forEach(function (row, index) {
    row.classList.remove("odd");
    if (hideableRows[index]) {
      $(row)
        .toggleClass("hidden")
        .slideToggle({
          duration: 200,
          start: function () {
            $(this).css({
              display: "flex",
            });
          },
        });
    }
    if (row.classList.contains("hidden")) {
      return;
    }
    if (isOdd) {
      row.classList.add("odd");
    }
    isOdd = !isOdd;
  });
  templateHidden[tableId] = !isHidden;
}

function showAllTables(showAllElement) {
  var caret = showAllElement.querySelector(".fas");
  caret.classList.toggle("fa-caret-down");
  caret.classList.toggle("fa-caret-up");
  Object.keys(template).forEach(function (key) {
    if (templateHidden[key] === allTablesShown) {
      hideTable(key);
    }
  });
  allTablesShown = !allTablesShown;
}

function tagsWrapper(content, tags) {
  return `<span class="${tags.join(" ")}">${content}</span>`;
}
// MODEL: LAPTOP DETAILS, BUY / REMOVE
function modelGen(data) {
  var modelKey = "MODEL";
  var infoKey = "INFO";

  function makeRow(content) {
    return `<tr class="compare__row">${content}</tr>`;
  }
  // Images
  function imageRow() {
    var cols = '<td class="compare__data">&nbsp;</td>';
    data.forEach(function (laptop) {
      var { IMG, COMP_NAME } = laptop[modelKey];
      var { CONF_ID } = laptop[infoKey];
      cols += `
        <td class="compare__data compare__img">
          <div
						style="background-image: url(res/img/models/thumb/t_${IMG}.jpg)"
            onclick="OpenPage('model/model.php?conf=${CONF_ID}',event)"
            role="button"
            tabIndex="0"
          ></div>
        </td>
      `;
    });
    return makeRow(cols);
  }
  // Name of the laptop
  function nameRow() {
    var cols = '<td class="compare__data">Name</td>';
    data.forEach(function (laptop) {
      var { COMP_NAME } = laptop[modelKey];
      var { CONF_ID } = laptop[infoKey];
      cols += `<td class="compare__data" style="cursor: pointer;"><strong onclick="OpenPage('model/model.php?conf=${CONF_ID}',event)">${COMP_NAME}</strong></td>`;
    });
    return makeRow(cols);
  }

  function affixRow() {
    var cols = '<td class="compare__data">Name</td>';
    data.forEach(function (laptop) {
      var { SIMPLE_NAME } = laptop[modelKey];
      cols += `<td class="compare__data"><strong>${SIMPLE_NAME}</strong></td>`;
    });
    return makeRow(cols);
  }
  // Ratings
  function ratingRow() {
    var cols = '<td class="compare__data">Rating</td>';

    data.forEach(function (laptop) {
      var { RATING } = laptop[modelKey];
      cols += `
        <td class="compare__data compare__progressBar">
          ${PROGRESSBAR.create({
            value: RATING,
            min: 0,
            max: 100,
            align: "center",
          })}
        </td>
      `;
    });
    return makeRow(cols);
  }
  // Price interval
  function priceRow() {
    var cols = '<td class="compare__data">Price</td>';
    data.forEach(function (laptop) {
      var { EXCH_SIGN, PRICE_MAX, PRICE_MIN } = laptop[modelKey];
      cols += `<td class="compare__data">${EXCH_SIGN}${PRICE_MIN} - ${PRICE_MAX}</td>`;
    });
    return makeRow(cols);
  }
  // Battery life
  function batteryRow() {
    var cols = '<td class="compare__data">Battery life</td>';
    data.forEach(function (laptop) {
      var { BATLIFE } = laptop[modelKey];

      BATLIFE =
        hourminutes(parseFloat(BATLIFE) * 0.96) +
        " - " +
        hourminutes(parseFloat(BATLIFE) * 1.03);
      cols += `<td class="compare__data">${BATLIFE} h</td>`;
    });
    return makeRow(cols);
  }
  // Buttons for each laptop
  function actionsRow() {
    var cols = '<td class="compare__data">&nbsp;</td>';
    data.forEach(function (laptop, index) {
      var { buyregions, conf_data, lang, mprod, pmodel, ref } =
        laptop[modelKey].BUY;
      var { CONF_ID } = laptop[infoKey];
      var commonId = `buylist-${index}`;
      cols += `
        <td class="compare__data">
          <div class="compare__actions">

            <div class="resultsShopBtn">
              <div class="dropdown">
                <button
                  type="button"
                  id="dLabel"
                  class="compare__btn compare__buy"
                  data-target="${commonId}"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"

                  ${conf_data}
                  data-buyregions=${buyregions}
                  data-lang="${lang}"
                  data-mprod="${mprod}"
                  data-pmodel="${pmodel}"
                  onclick="get_buy_list(this);"
                  data-ref="${ref}"
                >
                  Buy
                  <i class="fas fa-caret-down"></i>
                </button>

                <ul class="dropdown-menu" aria-labelledby="dLabel" id="${commonId}">
                  <li class="loaderContainer">
                    <span class="loader"></span>
                  </li>
                </ul>

              </div>
            </div>

            <div
              class="compare__btn compare__remove"
              onclick="removecomp('${CONF_ID}', 1)"
            >
            </div>
          </div>
        </td>
      `;
    });
    return `<tr class="compare__row">${cols}</tr>`;
  }

  function showMoreRow() {
    return `
      <tr class="compare__row compare__showAll" onclick="showAllTables(this)">
        <td>
          Show all <i class="fas fa-caret-down"></i>
        </td>
      </tr>
    `;
  }
  return `
    <table class="compare__table compare__name-affix hidden">
      ${affixRow()}
    </table>

    <table class="compare__table compare__model">
      
      ${imageRow()}

      ${nameRow()}

      <tr id="name-afix-hook"></tr><tr></tr>

      ${ratingRow()}

      ${priceRow()}

      ${batteryRow()}

      ${actionsRow()}

      ${showMoreRow()}

    </table>
  `;
}
// TABLE: where all the data is displayed
function tableGen(id, data) {
  // The template for the current table
  var tableTitle = template[id].title;
  var tableSchema = template[id].data;

  function makeCol(content) {
    return `<td class="compare__data">${content}</td>`;
  }
  // Row generator
  var isOdd = false;
  var rows = tableSchema.map(function ([title, key, hidden]) {
    var cells;
    // Map data into table cells
    cells = data.map(function (item) {
      // If there is no key, then the data is a msc string, so return it
      var content = item[id][key] || item[id];

      if (key === "rating") {
        content = PROGRESSBAR.create({
          value: content,
          min: 0,
          max: 100,
          maxWidth: "200px",
          align: "center",
        });
      }

      var tagsObj = item[id]["tags"];
      if (tagsObj && tagsObj[key]) {
        content = tagsWrapper(content, tagsObj[key]);
      }
      return makeCol(content);
    });
    // Add title as first cell
    cells.unshift(makeCol(title));
    // Bundle cells in a row
    var hiddenClass = hidden ? "hidden" : "";
    var oddClass = "";
    if (!hidden) {
      oddClass = isOdd ? "odd" : "";
      isOdd = !isOdd;
    }
    return `
      <tr
        class="compare__row ${oddClass} ${hiddenClass}"
        style='${hidden ? "display: none" : ""}'
      >
        ${cells.join("")}
      </td>
    `;
  });
  var tableName = `${id}_table`;
  var isDropdown = template[id].data.reduce(function (acc, val) {
    return acc || !!val[2];
  }, false);
  var handleClick = `hideTable('${id}')"`;
  return `
    <div
      id="${id}_title"
      class="compare__title ${isDropdown ? "clickable" : ""}"
      onclick="${isDropdown ? handleClick : ""}"
    >
      ${tableTitle}
      ${isDropdown ? '<i class="fas fa-caret-down"></i>' : ""}
    </div>
		<table id="${tableName}" class="compare__table">
      ${rows.join("")}
		</table>
  `;
}
// DRIVER CODE
// Gets the php generated object
phpData = (function () {
  var parsedData = Object.values(window.array_var_new).map(function (item) {
    var result = {
      ...item,
      MSC: {
        msc: item.MSC,
        war_time: item.WAR.years,
        war_msc: item.WAR.msc,
        os: item.OS.sist,
      },
    };
    return result;
  });
  return parsedData;
})();
// Creates an indexed array of booleans to record if a table is hidden or not
templateHidden = (function (tableTemplate) {
  var result = {};
  Object.keys(tableTemplate).forEach(function (key) {
    result[key] = false;
  });
  return result;
})(template);
// Creates the page
(function (phpData) {
  // Only run if a laptop exists
  var firstLaptop = phpData[0];
  if (!firstLaptop) {
    console.warn("No laptop to get models from");
    return;
  }
  var root = document.getElementById("tableRoot");
  if (!root) {
    console.warn("#tableRoot div is missing! Cannot insert tables to page!");
    return;
  }
  var mockup = "";
  mockup += modelGen(phpData, templateHidden);
  Object.keys(firstLaptop).forEach(function (key) {
    if (template[key]) {
      mockup += tableGen(key, phpData);
    }
  });
  root.innerHTML = mockup;
  // root.parentElement.removeChild(root);
})(phpData);
// Control affix
(function () {
  var nameAffixHookElement,
    nameAffixElement,
    nameAffixTrigger,
    nameAffixHidden = true,
    compareContainer;
  nameAffixHookElement = document.getElementById("name-afix-hook");
  nameAffixElement = document.getElementsByClassName("compare__name-affix")[0];
  compareContainer = document.getElementsByClassName("compare__container")[0];

  function getNewTrigger() {
    nameAffixTrigger =
      nameAffixHookElement.getBoundingClientRect().top +
      document.documentElement.scrollTop;
    nameAffixElement.style.left = `${
      compareContainer.getBoundingClientRect().left
    }px`;
    nameAffixElement.style.width = `${compareContainer.clientWidth}px`;
  }

  function toggleNameAffix() {
    var offset = document.documentElement.scrollTop;
    if ((offset < nameAffixTrigger) ^ nameAffixHidden) {
      nameAffixHidden = !nameAffixHidden;
      nameAffixElement.classList.toggle("hidden");
    }
  }
  getNewTrigger();
  window.addEventListener("resize", getNewTrigger);
  toggleNameAffix();
  window.addEventListener("scroll", toggleNameAffix);
})();
// CODE FROM BEFORE
setTimeout(function () {
  istime = 1;
}, 1500);
if ($(window).width() < 992) {
  $(".modelName").addClass("linked");
}
//Scroll affix mobile
$(".linked").scroll(function () {
  $(".linked").scrollLeft($(this).scrollLeft());
});

// GLOBAL EVENTS

$(document).ready(function () {
  actbtn("");
  show_buy_list = 1;
});
