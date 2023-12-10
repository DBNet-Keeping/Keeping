// 데이터를 출력할 HTML 요소 가져오기
const dataContainer = document.getElementById("subinfoprint");

// 데이터를 순회하면서 HTML에 추가
databaseData.forEach((data) => {
  // 새로운 p 태그 생성
  const pTag = document.createElement("p");

  // p 태그에 데이터 추가
  pTag.textContent = `ID: ${data.id}, Name: ${data.name}, Age: ${data.age}`;

  // 데이터를 표시할 곳에 p 태그 추가
  dataContainer.appendChild(pTag);

  // PHP 파일에서 데이터를 가져오기 위한 XMLHttpRequest 사용
  const xhr = new XMLHttpRequest();

  // XMLHttpRequest의 상태가 변경될 때 실행되는 함수
  xhr.onreadystatechange = function () {
    // XMLHttpRequest의 상태가 DONE(4)이고 HTTP 상태 코드가 200인 경우
    if (this.readyState == 4 && this.status == 200) {
      // JSON 형식의 데이터 파싱
      const data = JSON.parse(this.responseText);

      //데이터를 출력할 HTML 요소 가져오기
      const dataContainer = document.getElementById("dataContainer");

      // 데이터를 순회하면서 HTML에 추가
      data.forEach((item) => {
        // 새로운 p 태그 생성
        const pTag = document.createElement("p");

        // p 태그에 데이터 추가
        pTag.textContent = "";

        // 데이터를 표시할 곳에 p 태그 추가
        dataContainer.appendChild(pTag);
      });
    }
  };

  // PHP 파일에서 데이터를 가져올 URL 설정
  xhr.open("GET", "subscriptiondb.php", true);

  // 요청 보내기
  xhr.send();
});
