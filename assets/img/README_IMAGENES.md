# Guía de Imágenes para E-commerce

## Imágenes necesarias para el proyecto:

### Carrusel (Banner):
Coloca estas imágenes en `assets/img/`:
- `banner1.jpg` - Imagen principal del carrusel (1200x400px recomendado)
- `banner2.jpg` - Segunda imagen del carrusel (1200x400px)
- `banner3.jpg` - Tercera imagen del carrusel (1200x400px)

### Productos:
Coloca las imágenes de productos en `assets/img/`:
Las imágenes deben tener el nombre que está en la base de datos en el campo 'imagen'

Ejemplo:
- `mouse_logitech.jpg`
- `teclado_mecanico.jpg`
- `auriculares_rgb.jpg`
- `mousepad_xl.jpg`

## Recomendaciones:

1. **Tamaño de imágenes:**
   - Banners: 1200x400px
   - Productos: 500x500px (cuadradas)

2. **Formato:** JPG o PNG

3. **Optimización:** Mantén las imágenes por debajo de 500KB para mejor rendimiento

## Cómo agregar imágenes:

### Opción 1: Descargar imágenes de muestra
Puedes descargar imágenes gratuitas de:
- https://unsplash.com (busca "gaming mouse", "keyboard", etc.)
- https://pexels.com
- https://pixabay.com

### Opción 2: Usar imágenes de productos reales
Si tienes productos reales, toma fotos con buena iluminación y fondo blanco.

### Opción 3: Usar placeholders temporales
Puedes usar servicios como:
- https://via.placeholder.com/500x500.png?text=Producto
- https://picsum.photos/500/500

## Actualizar la base de datos:

Cuando agregues productos, asegúrate de que el campo 'imagen' en la tabla 'products' 
coincida con el nombre del archivo en la carpeta assets/img/

Ejemplo:
```sql
INSERT INTO products (nombre, precio_venta, categoria, imagen, stock) 
VALUES ('Mouse Logitech G305', 48000, 'Mouse', 'mouse_g305.jpg', 10);
```
