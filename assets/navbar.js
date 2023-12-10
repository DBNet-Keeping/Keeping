$(document).ready(function () {
  let last_s = document.URL.lastIndexOf("/");
  let last_o = document.URL.lastIndexOf(".");
  let file_name = document.URL.substring(last_s + 1, last_o);

  if (file_name == "modify" || file_name == "delete" || file_name == "account" || file_name == "yes_account" || file_name == "non_account") {
    file_name = "mypage";
  }

  $("#" + file_name).addClass("active");
  $("#" + file_name)
    .parent()
    .siblings()
    .find(".side")
    .removeClass("active");
});
