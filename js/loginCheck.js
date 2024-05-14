$(document).ready(function(){
  $('.form').submit(function(e){
      e.preventDefault();

      var formData = {
          email: $('#email').val(),
          password: $('#password').val()
      };

      $.ajax({
          url: 'php/loginCheck.php',  // Путь к вашему файлу для авторизации
          type: 'POST',  // Используем метод POST
          dataType: 'json',
          data: formData,
          success: function(response){
              if(response.status === 'success'){
                  window.location.href = 'user.html?id=' + response.user_id;
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
