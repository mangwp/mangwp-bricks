document.addEventListener("DOMContentLoaded", function () {
    var firstElement = document.querySelector("body");
    if (firstElement) {
      var customDiv = document.createElement("div");
      customDiv.className =
        "save-thumbnail-button";
      // Create an SVG element for the camera icon
      var svgIcon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
      svgIcon.setAttribute("xmlns", "http://www.w3.org/2000/svg");
      svgIcon.setAttribute("height", "16");
      svgIcon.setAttribute("width", "16");
      svgIcon.setAttribute("viewBox", "0 0 512 512");
      svgIcon.innerHTML =
        '<path d="M149.1 64.8L138.7 96H64C28.7 96 0 124.7 0 160V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H373.3L362.9 64.8C356.4 45.2 338.1 32 317.4 32H194.6c-20.7 0-39 13.2-45.5 32.8zM256 192a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/>';
  
      // Create a span element for the text content
      var textSpan = document.createElement("span");
      textSpan.textContent = "Screenshot";
  
      // Append the SVG icon and text content to the custom div
      customDiv.appendChild(svgIcon);
      customDiv.appendChild(textSpan);
  
      customDiv.style.top = "50%";
      customDiv.style.transform = "translateY(-50%)"; // Center vertically
  
      customDiv.addEventListener("click", function () {
        saveAsThumbnail("save-thumbnail-button");
      });
  
      firstElement.insertBefore(customDiv, firstElement.firstChild);
    }
  });
  
  function saveAsThumbnail() {
    html2canvas(document.getElementById("brx-content")).then(function (canvas) {
      var imageData = canvas.toDataURL("image/png");
  
      // Send the image data to the server using AJAX
      jQuery.ajax({
        type: "POST",
        url: wp_ajax.ajax_url,
        data: {
          action: "save_thumbnail",
          post_id: wp_ajax.post_id,
          image_data: imageData,
          nonce: wp_ajax.nonce,
        },
        success: function (response) {
          if (response.success) {
            var imageData = canvas.toDataURL("image/png");
            var imageData = imageData;
  
            if (imageData) {
              var lightboxLink = document.createElement("a");
              lightboxLink.href = imageData;
              lightboxLink.setAttribute("data-lightbox", "saved-thumbnails");
              lightboxLink.setAttribute("data-title", "Saved Thumbnail");
  
              var imageElement = document.createElement("img");
              imageElement.src = imageData;
              lightboxLink.appendChild(imageElement);
  
              document.body.appendChild(lightboxLink);
  
              lightboxLink.click();
  
              document.body.removeChild(lightboxLink);
            } else {
              console.error("Error getting image data from html2canvas");
              console.log(response); // Log the entire AJAX response
            }
          } else {
            console.error("Error saving thumbnail:", response.data);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          // Handle AJAX errors
          console.error("AJAX Error:", textStatus, errorThrown);
        },
      });
    });
  }
  