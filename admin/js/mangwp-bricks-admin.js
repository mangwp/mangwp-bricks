(function ($) {
  "use strict";

  /**
   * All of the code for your admin-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
})(jQuery);

document.addEventListener("DOMContentLoaded", function () {
  var tabWrapper = document.getElementById("mangwp-settings-tabs-wrapper");
  if (tabWrapper) {
    var tabs = tabWrapper.querySelectorAll("a.nav-tab");

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function (event) {
        event.preventDefault();

        // Remove active class from all tabs
        tabs.forEach(function (tab) {
          tab.classList.remove("nav-tab-active");
        });

        // Add active class to the clicked tab
        tab.classList.add("nav-tab-active");

        // Toggle the content based on the data-tab-id attribute
        var tabId = tab.getAttribute("data-tab-id");
        toggleTabContent(tabId);
      });
    });
  }

  function toggleTabContent(tabId) {
    // Hide all tab content
    var tabContents = document.querySelectorAll(".bricks-admin-wrapper .tab-content");
    tabContents.forEach(function (content) {
      content.classList.remove("active");
    });

    // Show the selected tab content
    var selectedTabContent = document.getElementById(tabId);
    if (selectedTabContent) {
      selectedTabContent.classList.add("active");
    }
  }
});
//body attribute

document.addEventListener("DOMContentLoaded", function () {
  var rowCounter =
    document.querySelectorAll(
      "tr.body-attribute table.table-repater-items tbody tr"
    ).length + 1;

  function addRow() {
    var tableBody = document.querySelector(
      "tr.body-attribute  table.table-repater-items tbody"
    );

    var newRow = document.createElement("tr");
    newRow.innerHTML =
      '<td><input type="text" name="mangwp_body_attributes[' +
      rowCounter +
      '][body_name]" value=""></td>' +
      '<td><textarea name="mangwp_body_attributes[' +
      rowCounter +
      '][body_value]" value=""></textarea></td>' +
      '<td class="delete"><button type="button" class="delete-row">x</button></td>';

    tableBody.appendChild(newRow);
    rowCounter++;
  }

  function deleteRow(event) {
    var deleteButton = event.target;
    var row = deleteButton.closest("tr");

    if (row) {
      // Find the input and textarea elements directly
      var inputName = row.querySelector(
        'input[name^="mangwp_body_attributes"]'
      );
      var textareaValue = row.querySelector(
        'textarea[name^="mangwp_body_attributes"]'
      );

      if (inputName && textareaValue) {
        // Check if it's the last row
        var isLastRow = row.parentNode.querySelectorAll("tr").length === 1;

        if (isLastRow) {
          inputName.value = ""; // Clear the input value
          textareaValue.value = ""; // Clear the textarea value
        } else {
          // If it's not the last row, remove the row
          row.parentNode.removeChild(row);
          updateRowCounter();
        }
      }
    }
  }

  function updateRowCounter() {
    var tableRows = document.querySelectorAll(
      "table.table-repater-items tbody tr.body-attribute "
    );
    rowCounter = tableRows.length + 1;
  }

  var checkbox = document.getElementById("mangwp-bricks-mangwp_body_attribute");
  var table = document.querySelector(
    "tr.body-attribute table.table-repater-items"
  );
  table.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-row")) {
      deleteRow(event);
    }
  });
  table.style.display = checkbox.checked ? "table" : "none";

  checkbox.addEventListener("change", function () {
    table.style.display = this.checked ? "table" : "none";
    // If the checkbox is unchecked, clear all inputted values
    if (this.checked && rowCounter === 1) {
      addRow();
    }
  });

  var addButton = document.querySelector(
    "tr.body-attribute table.table-repater-items tfoot span.button"
  );
  addButton.addEventListener("click", function () {
    if (checkbox.checked) {
      addRow();
    }
  });
});
// Main Tag

document.addEventListener("DOMContentLoaded", function () {
  var rowCounter =
    document.querySelectorAll("tr.main-attribute table.table-repater-items tbody tr").length + 1;

  function addRow() {
    var tableBody = document.querySelector("tr.main-attribute table.table-repater-items tbody");

    var newRow = document.createElement("tr");
    newRow.innerHTML =
      '<td><input type="text" name="mangwp_main_attributes[' +
      rowCounter +
      '][main_name]" value=""></td>' +
      '<td><textarea name="mangwp_main_attributes[' +
      rowCounter +
      '][main_value]" value=""></textarea></td>' +
      '<td class="delete"><button type="button" class="delete-row">x</button></td>';

    tableBody.appendChild(newRow);
    rowCounter++;
  }

  function deleteRow(event) {
    var deleteButton = event.target;
    var row = deleteButton.closest("tr");

    if (row) {
      // Find the input and textarea elements directly
      var inputName = row.querySelector(
        'input[name^="mangwp_main_attributes"]'
      );
      var textareaValue = row.querySelector(
        'textarea[name^="mangwp_main_attributes"]'
      );

      if (inputName && textareaValue) {
        // Check if it's the last row
        var isLastRow = row.parentNode.querySelectorAll("tr").length === 1;

        if (isLastRow) {
          inputName.value = ""; // Clear the input value
          textareaValue.value = ""; // Clear the textarea value
        } else {
          // If it's not the last row, remove the row
          row.parentNode.removeChild(row);
          updateRowCounter();
        }
      }
    }
  }

  function updateRowCounter() {
    var tableRows = document.querySelectorAll(
      "table.table-repater-items tbody tr.footer-attribute "
    );
    rowCounter = tableRows.length + 1;
  }

  var checkbox = document.getElementById("mangwp-bricks-mangwp_main_attribute");
  var table = document.querySelector("tr.main-attribute table.table-repater-items");
  table.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-row")) {
      deleteRow(event);
    }
  });
  table.style.display = checkbox.checked ? "table" : "none";

  checkbox.addEventListener("change", function () {
    table.style.display = this.checked ? "table" : "none";
    // If the checkbox is unchecked, clear all inputted values
    if (this.checked && rowCounter === 1) {
      addRow();
    }
  });

  var addButton = document.querySelector(
    "tr.main-attribute table.table-repater-items tfoot span.button"
  );
  addButton.addEventListener("click", function () {
    if (checkbox.checked) {
      addRow();
    }
  });
});

//Header attribute

document.addEventListener("DOMContentLoaded", function () {
  var rowCounter =
    document.querySelectorAll(
      "tr.header-attribute  table.table-repater-items tbody tr"
    ).length + 1;

  function addRow() {
    var tableBody = document.querySelector(
      "tr.header-attribute  table.table-repater-items tbody"
    );

    var newRow = document.createElement("tr");
    newRow.innerHTML =
      '<td><input type="text" name="mangwp_header_attributes[' +
      rowCounter +
      '][header_name]" value=""></td>' +
      '<td><textarea name="mangwp_header_attributes[' +
      rowCounter +
      '][header_value]" value=""></textarea></td>' +
      '<td class="delete"><button type="button" class="delete-row">x</button></td>';

    tableBody.appendChild(newRow);
    rowCounter++;
  }

  function deleteRow(event) {
    var deleteButton = event.target;
    var row = deleteButton.closest("tr");

    if (row) {
      // Find the input and textarea elements directly
      var inputName = row.querySelector(
        'input[name^="mangwp_header_attributes"]'
      );
      var textareaValue = row.querySelector(
        'textarea[name^="mangwp_header_attributes"]'
      );

      if (inputName && textareaValue) {
        // Check if it's the last row
        var isLastRow = row.parentNode.querySelectorAll("tr").length === 1;

        if (isLastRow) {
          inputName.value = ""; // Clear the input value
          textareaValue.value = ""; // Clear the textarea value
        } else {
          // If it's not the last row, remove the row
          row.parentNode.removeChild(row);
          updateRowCounter();
        }
      }
    }
  }

  function updateRowCounter() {
    var tableRows = document.querySelectorAll(
      "table.table-repater-items tbody tr.header-attribute "
    );
    rowCounter = tableRows.length + 1;
  }

  var checkbox = document.getElementById(
    "mangwp-bricks-mangwp_header_attribute"
  );
  var table = document.querySelector(
    "tr.header-attribute table.table-repater-items"
  );
  table.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-row")) {
      deleteRow(event);
    }
  });
  table.style.display = checkbox.checked ? "table" : "none";

  checkbox.addEventListener("change", function () {
    table.style.display = this.checked ? "table" : "none";
    // If the checkbox is unchecked, clear all inputted values
    if (this.checked && rowCounter === 1) {
      addRow();
    }
  });

  var addButton = document.querySelector(
    "tr.header-attribute table.table-repater-items tfoot span.button"
  );
  addButton.addEventListener("click", function () {
    if (checkbox.checked) {
      addRow();
    }
  });
});

//footer attribute

document.addEventListener("DOMContentLoaded", function () {
  var rowCounter =
    document.querySelectorAll(
      "tr.footer-attribute  table.table-repater-items tbody tr"
    ).length + 1;

  function addRow() {
    var tableBody = document.querySelector(
      "tr.footer-attribute  table.table-repater-items tbody"
    );

    var newRow = document.createElement("tr");
    newRow.innerHTML =
      '<td><input type="text" name="mangwp_footer_attributes[' +
      rowCounter +
      '][footer_name]" value=""></td>' +
      '<td><textarea name="mangwp_footer_attributes[' +
      rowCounter +
      '][footer_value]" value=""></textarea></td>' +
      '<td class="delete"><button type="button" class="delete-row">x</button></td>';

    tableBody.appendChild(newRow);
    rowCounter++;
  }

  function deleteRow(event) {
    var deleteButton = event.target;
    var row = deleteButton.closest("tr");

    if (row) {
      // Find the input and textarea elements directly
      var inputName = row.querySelector(
        'input[name^="mangwp_footer_attributes"]'
      );
      var textareaValue = row.querySelector(
        'textarea[name^="mangwp_footer_attributes"]'
      );

      if (inputName && textareaValue) {
        // Check if it's the last row
        var isLastRow = row.parentNode.querySelectorAll("tr").length === 1;

        if (isLastRow) {
          inputName.value = ""; // Clear the input value
          textareaValue.value = ""; // Clear the textarea value
        } else {
          // If it's not the last row, remove the row
          row.parentNode.removeChild(row);
          updateRowCounter();
        }
      }
    }
  }

  function updateRowCounter() {
    var tableRows = document.querySelectorAll(
      "table.table-repater-items tbody tr.footer-attribute "
    );
    rowCounter = tableRows.length + 1;
  }

  var checkbox = document.getElementById(
    "mangwp-bricks-mangwp_footer_attribute"
  );
  var table = document.querySelector(
    "tr.footer-attribute table.table-repater-items"
  );
  table.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-row")) {
      deleteRow(event);
    }
  });
  table.style.display = checkbox.checked ? "table" : "none";

  checkbox.addEventListener("change", function () {
    table.style.display = this.checked ? "table" : "none";
    // If the checkbox is unchecked, clear all inputted values
    if (this.checked && rowCounter === 1) {
      addRow();
    }
  });

  var addButton = document.querySelector(
    "tr.footer-attribute table.table-repater-items tfoot span.button"
  );
  addButton.addEventListener("click", function () {
    if (checkbox.checked) {
      addRow();
    }
  });
});
