$(document).ready(function() {
  $('#buyTicket').click(function() {
      // Получение значения id_session из адресной строки
      var urlParams = new URLSearchParams(window.location.search);
      var sessionId = urlParams.get('id');
      var title = $('#title').text();
      var duration = $('#duration').text();
      var ticket_price = $('#ticket_price').text();
      var contact_info = $('#contact_info').text();
      var theatre_name = $('#theatre_name').text();
      var addres = $('#addres').text();

      console.log(duration, title, theatre_name);

      // Отправка запроса на сервер с id_session
      $.ajax({
          url: 'php/buy_ticket.php',
          type: 'POST',
          dataType: 'json',
          data: {
            id_session: sessionId,
            Title: title,
            Duration: duration,
            Ticket_price: ticket_price,
            Contact_info: contact_info,
            Theatre_name: theatre_name,
            Addres: addres
          }, // Передача id_session на сервер
          success: function(response) {
            // Если запрос успешен, открываем сгенерированный билет в новой вкладке
            let filePath = response.file;
            console.log(response);
            window.open(filePath, '_blank');
            // Перезагрузка страницы после успешной покупки билета
            location.reload();
          },
          error: function(error) {
              console.error('Ошибка при покупке билета:', error);
          }
      });
  });
});
