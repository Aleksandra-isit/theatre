$(document).ready(function(){
  $.ajax({
      url: 'php/getPerformances.php',
      type: 'GET',
      dataType: 'json',
      success: function(response){
          if(response.status === 'success'){
              var performances = response.data;
              var listHtml = '';

              performances.forEach(function(performance){
                  listHtml += `
                      <li class="performances item">
                        <a href="performance.html?id=${performance.id_session}" class="perfornances__link">
                          <div class="card">
                            <div class="card__image" style="background-image: url(${performance.image_url})"></div>
                            <h2 class="card__title">${performance.title}</h2>
                          </div>
                        </a>
                      </li>
                  `;
              });

              $('.performances__list').html(listHtml);
          } else {
              console.log(response.message);
          }
      },
      error: function(error){
          console.log("Ошибка:", error);
      }
  });
});
