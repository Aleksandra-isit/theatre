ymaps.ready(init);
function init() {
  // Строка с адресом, который необходимо геокодировать
  let address = document.getElementById("addres");
  address = address.innerHTML;

  // Ищем координаты указанного адреса
  // https://tech.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode-docpage/
  let geocoder = ymaps.geocode(address);

  // После того, как поиск вернул результат, вызывается callback-функция
  geocoder.then(
    function (res) {
        // координаты объекта
        let coordinates = res.geoObjects.get(0).geometry.getCoordinates();

        // Создание карты.
        let myMap = new ymaps.Map("map", {
          center: coordinates,
          zoom: 12,
        });

        // Добавление метки (Placemark) на карту
        let placemark = new ymaps.Placemark(
            coordinates, {
                'hintContent': address,
            }, {
                'preset': 'islands#redDotIcon'
            }
        );

        myMap.geoObjects.add(placemark);
    }
  );
}
