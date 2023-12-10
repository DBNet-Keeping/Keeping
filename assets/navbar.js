$(document).ready(function () {
  let last_s = document.URL.lastIndexOf("/");
  let last_o = document.URL.lastIndexOf(".");
  let file_name = document.URL.substring(last_s + 1, last_o);

  $("#" + file_name).addClass("active");
  $("#" + file_name)
    .parent()
    .siblings()
    .find(".side")
    .removeClass("active");
});
