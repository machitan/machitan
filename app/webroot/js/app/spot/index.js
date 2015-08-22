$(function(){

  //File Upload
  window.addEventListener("load", function () {

      if (!window.File) {
          result.innerHTML = "File API 使用不可";
          return;
      }

      document.getElementById("imageFile").addEventListener("change", function () {
          var reader = new FileReader();

          reader.onload = function (event) {
              document.getElementById("image").src = reader.result;
          }
          var file = document.getElementById("imageFile").files[0];
          reader.readAsDataURL(file);
      }, true);
  }, true);


});
	
