$(document).ready(function(){
  // Получение ID постановки из URL
  const urlParams = new URLSearchParams(window.location.search);
  const id_session = urlParams.get('id');

  // Запрос к серверу для получения данных о постановке и театре
  $.ajax({
      url: 'php/getPerformanceDetails.php',
      type: 'GET',
      dataType: 'json',
      data: {id_session: id_session},
      success: function(response){
          if(response.status === 'success'){
              const data = response.data;
              $('.hero').css('background-image', 'url(' + data.image_url + ')');
              $('#gendre').text(data.gendre);
              $('#title').text(data.title);
              $('#start_date_time').text(data.start_date_time);
              $('#theatre_name').text(data.theatre_name);
              $('#count').text(data.count);
              $('#description').text(data.description);
              $('#addres').text(data.addres);
              $('#contact_info').text(data.contact_info);
              $('#duration').text(data.duration + ' мин.');
              $('#available_seats').text(data.available_seats);
              $('#ticket_price').text(data.ticket_price + ' руб.');
          } else {
              alert('Ошибка при загрузке данных');
          }
      },
      error: function(error){
          console.log("Ошибка:", error);
      }
  });
});
