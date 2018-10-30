function refreshDiv(){
  fetch('chat_auto.php').then(function(response){
    response.text().then(function(text){
      document.querySelector('#chatbox').innerHTML = text;
    })
  });
}
