Para insertar el formulario de busqueda se debe incluir la siguiente etiqueta:

[bd-searchbox-one]

Despues debemos destinar una pagina para mostrar los resultados e incluir la siguiente etiqueta:

[etravel-container]

Despues creamos una página para mostrar el detalle del hotel y le asignamos otra etiqueta:

Es necesario incluir el siguiente cron para limpiar la carpeta de cache todos los días

rm -rf public_html/wp-content/plugins/e-travel-api-vxl/temp/*

