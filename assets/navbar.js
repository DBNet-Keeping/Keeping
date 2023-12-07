$(document).ready(function () {
  // 네비게이션 바 버튼에 클릭 이벤트 리스너 추가
  $("#home").addClass("active");
  $(".side").click(function () {
    // 클릭된 버튼의 부모(<li>)에 'active' 클래스 추가
    $(this).addClass("active");

    // 클릭된 버튼의 형제(<li>)들에서 'active' 클래스 제거
    $(this).parent().siblings().find(".side").removeClass("active");
  });
});
