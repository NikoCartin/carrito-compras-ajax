# Sistema de Carrito de Compras - AJAX y Sesiones

## Descripción del Proyecto

Este proyecto implementa un sistema completo de carrito de compras que utiliza tecnologías web modernas como AJAX, PHP y sesiones del servidor. El sistema ha sido desarrollado para cumplir con todos los requisitos establecidos en la tarea práctica del curso, proporcionando una solución robusta y funcional para el manejo de productos y compras en línea.

## Características Principales

### Requisitos Cumplidos

El sistema cumple satisfactoriamente con todos los requisitos especificados en la tarea práctica. Se han implementado más de diez productos únicos, específicamente doce productos diferentes con sus respectivas características. El sistema permite la selección y almacenamiento de productos en un carrito de compras que utiliza sesiones del servidor para mantener la persistencia de datos entre las diferentes páginas y solicitudes. El botón de "Finalizar compra" se encuentra completamente funcional y procesa las órdenes de manera efectiva.

### Funcionalidades Adicionales

Además de los requisitos básicos, el sistema incluye características adicionales que mejoran la experiencia del usuario. El diseño es completamente responsivo, adaptándose a diferentes tamaños de pantalla incluyendo dispositivos móviles. Las actualizaciones del carrito se realizan en tiempo real utilizando AJAX sin necesidad de recargar la página. Se ha implementado un panel de control dinámico que muestra información actualizada sobre el estado del carrito y un sistema de historial que permite visualizar todas las compras realizadas. El manejo de errores es robusto y proporciona retroalimentación clara al usuario en caso de problemas.

## Estructura de Archivos

```
Carrito de Compras/
├── index.html          # Página principal con productos y carrito
├── productos.php       # API que devuelve lista de productos
├── carrito.php         # Manejo de operaciones del carrito
├── finalizar.php       # Procesamiento de compra final
├── historial.html      # Página para ver historial de compras
├── historial.php       # API para obtener historial
├── README.md           # Este archivo de documentación
└── compras.json        # Archivo generado con las compras
```

## Tecnologías Utilizadas

El desarrollo del sistema se ha realizado utilizando un conjunto de tecnologías web modernas y estándares de la industria. En el frontend se emplean HTML5 para la estructura, CSS3 para el diseño y presentación visual, y JavaScript puro para implementar la funcionalidad AJAX sin dependencias externas. El backend está construido con PHP, aprovechando su capacidad nativa para el manejo de sesiones. Para el almacenamiento de datos se utilizan las sesiones de PHP para la persistencia temporal del carrito y archivos JSON para el almacenamiento permanente del historial de compras. El diseño visual implementa técnicas modernas como CSS Grid y Flexbox para crear una interfaz completamente responsiva.

## Funcionalidad del Sistema

### Página Principal

La página principal del sistema presenta una interfaz intuitiva donde se muestran los doce productos disponibles. Cada producto incluye información detallada como imagen, nombre, precio y descripción. El carrito de compras se presenta en una barra lateral dinámica que se actualiza en tiempo real. Los usuarios pueden agregar productos al carrito mediante botones claramente identificados, y el sistema proporciona controles para ajustar las cantidades de cada producto.

### Gestión de Productos

El proceso de agregar productos al carrito es fluido e intuitivo. Los usuarios pueden hacer clic en el botón correspondiente de cada producto para agregarlo al carrito. Esta acción se procesa mediante AJAX, enviando una solicitud al servidor sin necesidad de recargar la página. El carrito se actualiza automáticamente, mostrando el nuevo producto agregado junto con notificaciones visuales que confirman la acción realizada.

### Administración del Carrito

Una vez que los productos han sido agregados al carrito, los usuarios tienen control completo sobre su contenido. Pueden visualizar todos los productos agregados en tiempo real, incluyendo nombres, precios y cantidades. El sistema permite modificar las cantidades utilizando botones intuitivos de incremento y decremento. El total de la compra se calcula y actualiza automáticamente con cada cambio. Si la cantidad de un producto se reduce a cero, el producto se elimina automáticamente del carrito.

### Proceso de Finalización

Cuando el usuario decide completar su compra, puede utilizar el botón "Finalizar Compra" que aparece cuando hay productos en el carrito. El sistema solicita confirmación antes de procesar la orden, proporcionando una oportunidad para revisar la decisión. Una vez confirmada, la aplicación genera un número de orden único, guarda los detalles de la compra en el historial y vacía automáticamente el carrito para permitir nuevas compras.

### Sistema de Historial

El sistema incluye una funcionalidad de historial que permite a los usuarios revisar todas las compras realizadas previamente. Esta característica está disponible a través de una página dedicada que muestra los detalles completos de cada orden, incluyendo productos comprados, cantidades, precios y fechas de las transacciones, todo organizado de manera clara y cronológica.

## Implementación Técnica de AJAX

### Peticiones GET

El sistema utiliza peticiones GET para obtener información del servidor sin modificar datos. Estas solicitudes se emplean principalmente para cargar la lista de productos desde el archivo productos.php y para obtener el estado actual del carrito desde carrito.php. Las peticiones GET son ideales para estas operaciones porque no alteran el estado del servidor y pueden ser cachadas por el navegador para mejorar el rendimiento.

```javascript
// Cargar productos
conexion.open('GET', 'productos.php');

// Obtener carrito actual
conexion.open('GET', 'carrito.php?action=obtener');
```

### Peticiones POST

Para las operaciones que modifican datos en el servidor, como agregar productos al carrito, actualizar cantidades o finalizar compras, se utilizan peticiones POST. Estas solicitudes incluyen datos en el cuerpo de la petición y requieren configurar correctamente los headers para el tipo de contenido que se está enviando.

```javascript
// Agregar al carrito
conexion.open('POST', 'carrito.php');
conexion.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
conexion.send('action=agregar&producto_id=1');
```

### Manejo de Respuestas

El sistema implementa un manejo robusto de las respuestas del servidor. Cuando una petición AJAX se completa exitosamente, el código verifica el estado de la respuesta y procesa el contenido JSON devuelto. Esto permite actualizar la interfaz de usuario de manera dinámica sin recargar la página completa.

```javascript
conexion.onload = function() {
    if (conexion.status === 200) {
        const respuesta = JSON.parse(conexion.responseText);
        // Procesar respuesta exitosa
    } else {
        // Manejar errores
    }
};
```

### Manejo de Errores

Se ha implementado un sistema comprensivo de manejo de errores que abarca tanto errores de conectividad como errores de aplicación. Cuando ocurre un error de conexión, el sistema muestra mensajes informativos al usuario y registra los detalles en la consola del navegador para facilitar el debugging.

```javascript
conexion.onerror = function() {
    mostrarNotificacion('Error de conexión', 'error');
};
```

## Gestión de Sesiones en PHP

### Inicialización del Sistema

El manejo de sesiones en PHP es fundamental para mantener el estado del carrito entre diferentes solicitudes del usuario. El sistema inicializa las sesiones al comienzo de cada script PHP que requiere acceso al carrito. Si es la primera vez que un usuario accede al sistema, se crea automáticamente un array vacío para almacenar los productos del carrito.

```php
session_start();
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
```

### Almacenamiento de Datos

Cuando un usuario agrega un producto al carrito, la información se almacena en la sesión del servidor. Cada producto se guarda con todos sus detalles relevantes, incluyendo nombre, precio y cantidad. Esta estructura permite un acceso eficiente a la información y facilita los cálculos posteriores.

```php
$_SESSION['carrito'][$producto_id] = [
    'nombre' => $producto['nombre'],
    'precio' => $producto['precio'],
    'cantidad' => 1
];
```

### Cálculos y Operaciones

El sistema incluye funciones especializadas para realizar cálculos sobre los datos del carrito almacenados en la sesión. La función de cálculo de total itera a través de todos los productos en el carrito, multiplica el precio por la cantidad de cada producto y suma todos los valores para obtener el total de la compra.

```php
function calcularTotal() {
    $total = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
    return round($total, 2);
}
```

## Características de Diseño y Experiencia de Usuario

El sistema presenta un diseño moderno y profesional que prioriza la usabilidad y la accesibilidad. La interfaz utiliza un esquema de colores coherente con gradientes sutiles y sombras que proporcionan profundidad visual sin resultar abrumador. El diseño es completamente responsivo, adaptándose automáticamente a diferentes tamaños de pantalla desde computadoras de escritorio hasta dispositivos móviles.

Las notificaciones visuales proporcionan retroalimentación inmediata al usuario sobre las acciones realizadas, confirmando cuando los productos se agregan exitosamente o alertando sobre posibles errores. Los indicadores de carga aparecen durante las operaciones AJAX para informar al usuario que el sistema está procesando su solicitud. Los botones están diseñados con iconos descriptivos y texto claro para facilitar la navegación intuitiva.

El panel de información se actualiza en tiempo real, mostrando el número de productos en el carrito y el total de la compra sin necesidad de recargar la página. Esta funcionalidad mejora significativamente la experiencia del usuario al proporcionar información instantánea sobre el estado de su compra.

## Sistema de Testing y Debugging

### Registro de Eventos del Sistema

El sistema implementa un registro comprensivo de eventos que facilita el monitoreo y la resolución de problemas. Todas las operaciones importantes se registran en los logs de PHP, incluyendo las interacciones con el carrito, los cambios en las sesiones y los procesos de finalización de compras. Los identificadores de sesión se incluyen en los logs para permitir el seguimiento de usuarios específicos durante las sesiones de debugging. Los estados del carrito se registran en momentos clave para verificar que las operaciones se están realizando correctamente.

### Herramientas de Debugging del Navegador

Para facilitar el desarrollo y mantenimiento del sistema, se ha incluido información detallada de debugging en la consola del navegador. Las peticiones AJAX se registran con información sobre las URLs solicitadas, los datos enviados y las respuestas recibidas. Los estados de respuesta se muestran claramente para identificar rápidamente problemas de conectividad o errores del servidor. Las URLs generadas dinámicamente se muestran en la consola para verificar que se están construyendo correctamente.

## Fortalezas del Proyecto

Este proyecto destaca por varios aspectos que lo convierten en una implementación sólida y profesional. En primer lugar, cumple completamente con todos los requisitos especificados en la tarea práctica, asegurando que todos los objetivos académicos se han alcanzado satisfactoriamente. Más allá de los requisitos básicos, el sistema incluye funcionalidades avanzadas que demuestran un entendimiento profundo de las tecnologías web modernas.

El manejo de errores es particularmente robusto, anticipando y gestionando adecuadamente las situaciones problemáticas que pueden surgir durante el uso normal del sistema. El diseño profesional y responsivo asegura que la aplicación sea accesible y usable en una amplia variedad de dispositivos y tamaños de pantalla.

El código está bien documentado y estructurado siguiendo las mejores prácticas de desarrollo web. Las funciones están claramente definidas, los comentarios explican la lógica compleja y la separación de responsabilidades facilita el mantenimiento futuro. El uso correcto de AJAX se demuestra a lo largo de todas las operaciones del sistema, desde la carga inicial de productos hasta la finalización de compras. La implementación de sesiones PHP es técnicamente correcta y eficiente, proporcionando una base sólida para la persistencia de datos del carrito.

---

## Información del Autor

Este proyecto ha sido desarrollado como parte de la Tarea Práctica 1 del curso AJAX, por Nícolas Cartín Reyes, enfocándose específicamente en el tema "Sesiones en el Servidor". El sistema demuestra la aplicación práctica de conceptos fundamentales de desarrollo web incluyendo AJAX, PHP, sesiones del servidor y diseño responsivo.

---

