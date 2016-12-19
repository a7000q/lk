ymaps.ready(function(){

    var coords = [55.76, 37.64];

    var points = $('#points').children('.point');


    var myMap = new ymaps.Map('myMap', {
        // центр и коэффициент масштабирования однозначно
        // определяют область картографирования
        center: coords,
        zoom: 7
    });

    points.each(function () {
        var name = $(this).children('.name').val();
        var description = $(this).children('.description').val();
        var coords = $(this).children('.coords').val();

        coords = coords.split(",");

        var myPlacemark = new ymaps.Placemark(coords, {
            hintContent: name,
            balloonContent: description
        });
        myMap.geoObjects.add(myPlacemark);
    });





});
