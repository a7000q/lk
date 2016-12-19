ymaps.ready(function(){
    var coords = $('#point_coords').val();
    var point_bool = false;

    if (coords != "")
    {
        coords = coords.split(",");
        point_bool = true;
    }
    else
        coords = [55.76, 37.64];


    var myMap = new ymaps.Map('myMap', {
        // центр и коэффициент масштабирования однозначно
        // определяют область картографирования
        center: coords,
        zoom: 7
    });

    if (point_bool)
    {
        var myPlacemark = new ymaps.Placemark(coords);
        myMap.geoObjects.add(myPlacemark);
    }

    myMap.events.add('click', function (e) {
        // Получение координат щелчка
        myMap.geoObjects.removeAll();

        var coords = e.get('coords');

        myGeoObject = new ymaps.GeoObject({
            geometry: {
                type: "Point",// тип геометрии - точка
                coordinates: coords // координаты точки
            }
        });

        myMap.geoObjects.add(myGeoObject); // Размещение геообъекта на карте.

        $('#point_coords').val(coords);
        $('#edit-point').submit();
    });
});