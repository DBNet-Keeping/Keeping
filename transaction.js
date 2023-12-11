function changeMonth(offset) {
    var currentMonthElement = document.getElementById('currentMonth');
    var hiddenCurrentMonthInput = document.getElementById('hiddenCurrentMonth');
    var currentMonth = parseInt(currentMonthElement.innerText);
    var newMonth = currentMonth + offset;

    // 1월보다 작아지거나 12월보다 커지는 것을 방지
    if (newMonth < 1) newMonth = 12;
    else if (newMonth > 12) newMonth = 1;

    // 화면과 hidden 필드에 새로운 월을 업데이트합니다.
    currentMonthElement.innerText = newMonth;
    hiddenCurrentMonthInput.value = newMonth;
}







