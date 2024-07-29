document.getElementById('vuelo-form').addEventListener('submit', function(event) {
    var plazas = document.getElementsByName('plazas')[0].value;
    var precio = document.getElementsByName('precio')[0].value;

    if (isNaN(plazas) || plazas <= 0 || isNaN(precio) || precio <= 0) {
        alert('Por favor, ingrese valores numéricos válidos para plazas y precio.');
        event.preventDefault();
    }
});

document.getElementById('hotel-form').addEventListener('submit', function(event) {
    var habitaciones = document.getElementsByName('habitaciones')[0].value;
    var tarifa = document.getElementsByName('tarifa')[0].value;

    if (isNaN(habitaciones) || habitaciones <= 0 || isNaN(tarifa) || tarifa <= 0) {
        alert('Por favor, ingrese valores numéricos válidos para habitaciones y tarifa.');
        event.preventDefault();
    }
});