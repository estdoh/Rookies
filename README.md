# **Design Products**

## METODO GET - endpoint 'api/products' ๐

Trae todos los productos existentes
        {
        "id": 3,
        "category": "Adaptaciones",
        "name": "ADAPTACIONES",
        "description": "loremp ipsum",
        "price": 0
        }

### METODO GET - endpoint 'api/products/:ID' ๐
Trae un product segun su ID

### Parametros URL ๐
 Los parametros son: ***sort, orderby, page y limit.***

ej: ` /api/products?sort=name&orderby=asc `
Ordena los comentarios en forma desendente o asendente segun el name

ej: ` /api/products?sort=name&orderby=asc&page=1&limit=5 `
Se filta todos los comentarios de una forma paginada con un limite de items

## METODO POST - endpoint '*products'๐
Insert product

endpoint: `/api/product`
Para insertar un nuevo producto usar un JSON de este formato
       {
        "category": "Adaptaciones",
        "name": "ADAPTACIONES",
        "description": "loremp ipsum",
        "price": "0"
        }

## METODO DELETE - endpoint '*products/:ID' ๐

endpoint: `/api/product/3` 
se elimina por el numero id del producto

## METODO PUT - endpoint '*products/:ID' ๐

se edita segun el id del producto a actualizar
        {
        category: "BRANDING",
        name: "BRANDING",
        description: "loremp ipsum",
        price: "0"
        }

# El Recurso de Users, Categories y Customers se manejan igual a los anteriores ๐จโ๐ฉโ๐งโ๐ฆ

# El Recurso de Usuarios por meido de Autorizacion โ๏ธ
## MEtodo GET '*Usuarios*' ๐
ej: `/api/token`

En postman ***Authorization*** - ***Basic Auth*** Username y Password valido y luego nos dara el ***Token*** que necesitamos para seguir haciendo el PUT.

ej:`/api/token/usuario/qwerty@qwerty.com`

Luego haciendo el mismo procedimiento pero seleccioando ***Bearer Token*** , nos dara la informacion del usuario que estamos pidiendo hay que poner el Email (ej: qwerty@qwerty.com) 
