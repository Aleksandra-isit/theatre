$(document).ready(function(){
  // Получение id пользователя из URL
  var urlParams = new URLSearchParams(window.location.search);
  var userId = urlParams.get('id');

  // Загрузка данных пользователя
  $.ajax({
      url: 'php/getUser.php',  // Создайте этот файл для получения данных пользователя
      type: 'GET',
      dataType: 'json',
      data: {id: userId},
      success: function(response){
          if(response.status === 'success'){
              $('#surname').text(response.data.last_name);
              $('#name').text(response.data.first_name);
              $('#email').text(response.data.email);
              $('#tel').text(response.data.phone_number);
          } else {
              alert(response.message);
          }
      },
      error: function(error){
          console.log("Ошибка:", error);
      }
  });

  // Обработка выхода из личного кабинета
  $('#exitBtn').click(function(e){
      e.preventDefault();

      // Очистка сессии
      $.ajax({
          url: 'php/logout.php',  // Создайте этот файл для выхода из сессии
          type: 'GET',
          dataType: 'json',
          success: function(response){
              if(response.status === 'success'){
                  window.location.href = 'index.html';  // Перенаправление на главную страницу
              } else {
                  alert(response.message);
              }
          },
          error: function(error){
              console.log("Ошибка:", error);
          }
      });
  });
});
