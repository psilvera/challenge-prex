
# Challenge PREX

API REST desarrollada en Laravel 10. Se integra con la API de GIPHY para búsqueda de GIFs, los guarda como favoritos y utiliza OAuth2.

📥 [**VER ESPECIFICACIONES**](DOCS/CHALLENGE.pdf)

---

## 🚀 Despliegue del Proyecto

### ⚙️ Requisitos Previos

- Docker & Docker Compose  
- Postman

---

### 1. Clonar el repositorio

```bash
git clone https://github.com/psilvera/challenge-prex.git
```
```bash
cd challenge-prex
```
---

### 2. Levantar los contenedores

El proyecto utiliza Docker Compose, por lo tanto **no es necesario crear la base de datos manualmente**.  
Se genera automáticamente al levantar el contenedor `prex-mariadb`

Para levantar los tres contenedores:

```bash
docker compose up --build -d
```

**Servicios desplegados:**

| Contenedor    | Software          |
|---------------|-------------------|
| PREX-PHP      | PHP 8.2           |
| PREX-MARIADB  | MariaDB 10.11     |
| PREX-NGINX    | Nginx 1.26        |

---

### 3. Acceder al contenedor de PHP

```bash
docker exec -ti prex-php bash
```
#### Ejecutar los siguientes comandos:

##### Crear el archivo .env
```bash
cp .env.example .env
```
> 🔐 Nota: en el .env se incluye una clave pública de GIPHY para permitir la prueba de los endpoints. Esta clave es gratuita y no representa ningún riesgo de seguridad, tampoco tiene costo alguno.

##### Instala las dependencias
```bash
composer install
```
##### Configuración del Entorno
```bash
php artisan prex:install
```

📌 Este comando `prex:install` es un comando personalizado que corre otros dos comandos `configure:permissions` y `passport:secret`. Uno setea los permisos necesarios en los directorios de Laravel
y otro crea un cliente passport cuyas credenciales `client_id` y `client_secret` se guardan en el archivo `.env`. Estos datos luego son utilizados por el servicio /login para generar
el Token OAuth2. Tambien corre las migraciones y los seeders.

---

### 4. Tests Unit/Feature

En este momento se pueden ejecutar los Tests

```bash
php artisan test
```

---

### 5. Testear con Postman

🧭 El archivo de la coleccón se encuentra el directorio *POSTMAN*

⚠️ Se necesita crear manualmente un environment y dentro crear la variable `{{access_token}}`. Luego de seleccionar el environment creado, el endpoint `/login` almacenará automáticamente el token recibido en esa variable y así funcionarán los demás endpoints.

---

#### Endpoints disponibles:

- `POST /api/giphy/login`  
- `POST /api/giphy/favorite`  
- `GET  /api/giphy/search`
- `GET  /api/giphy/id/xT1Ra1NBgzJbnyibIY`

---

## 📐 Links de los Diagramas

- [🧭 Diagrama de Casos de Uso (PlantUML)](https://tinyurl.com/psilvera-prex-casosuso)  
- [📤 Diagrama de Secuencia (PlantUML)](https://tinyurl.com/psilvera-secuenciadiag-prex)  
- [🗃️ Diagrama Entidad-Relación (dbdiagram.io)](https://dbdiagram.io/d/DER_GIPHY_API-67f993094f7afba1844d8e57)
- [📬 Colección de Postman](POSTMAN/colleccion.json)  

---

## 📊 Imágenes de los Diagramas

- 🗂️ [Diagrama de Casos de Uso en PlantUML](DOCS/CASOS_DE_USO_plantuml.png)  
- 📤 [Diagrama de Secuencia en PlantUML](DOCS/DIAGRAMA_SECUENCIA_plantuml.png)  
- 🗃️ [Diagrama de Entidad Relación en dbdiagram.io](DOCS/DER_dbdiagram.png)  
- ✅ [Tests Unit/Feature (Feature y Unitarios)](DOCS/tests_ok.png)

---

**Pablo Silvera**  
📧 [pablo.silvera@gmail.com](mailto:pablo.silvera@gmail.com)  
💼 [LinkedIn](https://linkedin.com/in/pablosilvera)  




