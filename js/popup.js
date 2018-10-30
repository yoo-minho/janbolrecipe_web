function setCookie(name, value, expiredays) {
    var today = new Date();
    today.setDate(today.getDate() + expiredays);
    document.cookie = name + '=' + escape(value) + '; path=/; expires=' + today.toGMTString() + ';'
}

function closePop() {
  if(document.forms[0].todayPop.checked)
    setCookie('popupcheck', 'limit', 1);
    self.close();
}

// document.cookie 는 텍스트 형태의 페이지를 긁어오는 것
// document.cookie.length 클라이언트의 쿠키 개수
// document.cookie.substring(a,b) a부터 b까지 읽어오는 것
// document.cookie.indexOf(a,b) b부터 a를 찾으면 몇번째 수임? -1 리턴은 없다는것

function getCookie(name){
  var wc_name = name + '=';
  var wc_start, wc_end, end;
  var i = 0;
  while(i <= document.cookie.length) {
    wc_start = i; wc_end = (i + wc_name.length);

    //쿠키 위치를 찾았을 때
    if(document.cookie.substring(wc_start, wc_end) == wc_name) {
      //쿠키 위치부터 ;이 처음 나타날때 전체 쿠키에서 몇번째 수인지 end 담기
      //만약 없다면 end는 끝수를 담아줘.
      if((end = document.cookie.indexOf(';', wc_end)) == -1){
        end = document.cookie.length;
      }
      //쿠키 위치에서 ;까지 해당하는 글을 리턴
      return document.cookie.substring(wc_end, end);
    }

    //★ while문을 돌리기 위해
    //★ 값이 있으면 +1, 값이 없을때 -1
    //★ 리턴할 수 있게 활용함
    i = document.cookie.indexOf('', i) + 1;
    if(i == 0){break;}
  }
  //해당하는 값이 없으면 아무것도 리턴하지 않음.
  return '';
}
