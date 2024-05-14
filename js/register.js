$(document).ready(function(){
  $('.form').submit(function(e){
      e.preventDefault(); // Предотвратить стандартное действие формы

      var formData = {
          first_name: $('#first_name').val(),
          last_name: $('#last_name').val(),
          email: $('#email').val(),
          phone_number: $('#phone_number').val(),
          password: $('#password').val()
      };

      $.ajax({
          url: 'php/register.php',
          type: 'POST',
          contentType: 'application/json',
          data: JSON.stringify(formData),
          success: function(response){
              if(response.status === 'success'){
                  // Перенаправление на страницу user.html
                  window.location.href = 'index.html';
              } else {
                  // Отобразить сообщение об ошибке
                  alert(response.message);
              }
          },
          error: function(error){
              console.log("Ошибка:", error);
          }
      });
  });
});
