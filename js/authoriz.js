$(document).ready(function(){
  $('#userAccount').click(function(){
      $.ajax({
          url: 'php/checkAuth.php',
          type: 'GET',
          dataType: 'json',
          success: function(response){
              if(response.status === 'authorized'){
                  // Перенаправление на страницу профиля
                  window.location.href = 'user.html?id=' + response.user_id;
              } else {
                  // Перенаправление на страницу входа
                  window.location.href = 'login.html';
              }
          },
          error: function(error){
              console.log("Ошибка:", error);
          }
      });
  });
});
