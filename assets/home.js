window.onload = function () {
  var day = new Date();
  var int_month = parseInt(day.getMonth() + 1);
  var char_month;
  switch (int_month) {
    case 1:
      char_month = "January";
      break;
    case 2:
      char_month = "February";
      break;
    case 3:
      char_month = "March";
      break;
    case 4:
      char_month = "April";
      break;
    case 5:
      char_month = "May";
      break;
    case 6:
      char_month = "June";
      break;
    case 7:
      char_month = "July";
      break;
    case 8:
      char_month = "August";
      break;
    case 9:
      char_month = "September";
      break;
    case 10:
      char_month = "October";
      break;
    case 11:
      char_month = "November";
      break;
    case 12:
      char_month = "December";
      break;
    default:
      break;
  }
  document.getElementById("month").innerHTML = char_month;
};
