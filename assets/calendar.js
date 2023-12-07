const daysTag = document.querySelector(".days"), // 요일을 나타내는 태그
  currentDate = document.querySelector(".current-date"), // 현재 날짜를 나타내는 태그
  prevNextIcon = document.querySelectorAll(".icons span"); // 이전, 다음 아이콘을 나타내는 태그

// 새로운 날짜, 현재 년도 및 월 가져오기
let date = new Date(),
  currYear = date.getFullYear(),
  currMonth = date.getMonth();

// 모든 월의 전체 이름을 배열에 저장
const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

// 캘린더 렌더링 함수
const renderCalendar = () => {
  let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // 현재 월의 첫 요일 가져오기
    lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // 현재 월의 마지막 날 가져오기
    lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // 현재 월의 마지막 요일 가져오기
    lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // 이전 월의 마지막 날 가져오기
  let liTag = "";

  for (let i = firstDayofMonth; i > 0; i--) {
    // 이번 월의 첫 요일부터 0(일요일)까지 for문 반복
    liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
  }

  for (let i = 1; i <= lastDateofMonth; i++) {
    // 현재 월의 날짜 수 만큼 li 생성
    // 현재 날짜, 월, 년이 일치하면 li 에 active 클래스 추가
    let isToday = i === date.getDate() && currMonth === new Date().getMonth() && currYear === new Date().getFullYear() ? "active" : "";
    liTag += `<li class="${isToday}">${i}</li>`;
  }

  for (let i = lastDayofMonth; i < 6; i++) {
    // 다음 월의 처음 날짜로부터 6(토요일)까지 for문 반복
    liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
  }
  currentDate.innerText = `${months[currMonth]} ${currYear}`; // 현재 월과 년도를 텍스트로 나타내기
  daysTag.innerHTML = liTag;
};
renderCalendar(); // 초기 캘린더 렌더링

prevNextIcon.forEach((icon) => {
  // 이전, 다음 아이콘 클릭 이벤트 리스너 추가
  icon.addEventListener("click", () => {
    // 클릭된 아이콘이 이전 아이콘이면 현재 월을 1 감소, 아니면 1 증가
    currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

    if (currMonth < 0 || currMonth > 11) {
      // 현재 월이 0보다 작거나 11보다 크면
      // 새로운 년도 및 월을 가진 날짜를 만들어 date 값으로 전달
      date = new Date(currYear, currMonth, new Date().getDate());
      currYear = date.getFullYear(); // 년도 업데이트
      currMonth = date.getMonth(); // 월 업데이트
    } else {
      date = new Date(); // 현재 날짜를 date 값으로 전달
    }
    renderCalendar(); // 렌더링 함수 호출
  });
});
