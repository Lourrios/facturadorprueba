<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Practica Profesional 2025"></a></p>


## Instalacion de proyecto de facturacion - Vida Digital

### 🔁 1. Clonar el repositorio

```bash
git clone https://github.com/Lourrios/facturadorprueba.git
cd facturadorprueba
```

> ⚠️ Asegúrate de cambiar a la **rama principal del proyecto**, por ejemplo:
```bash
git checkout nombre-de-la-rama``
```

---

### ⚙️ 2. Crear base de datos y configurar archivo `.env`

Copiar el archivo `.env.example` y crear el archivo de configuración del entorno:

```bash
cp .env.example .env
```

Configurar los siguientes campos en el archivo `.env`:

- Nombre de la base de datos
- Usuario y contraseña de MySQL
- Configuración de correo (Mailtrap recomendado)

```env
DB_DATABASE=nombre_de_base
DB_USERNAME=usuario
DB_PASSWORD=contraseña

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxxxxx
MAIL_PASSWORD=xxxxxx
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=example@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

### 🧱 3. Instalar dependencias

### 📦 Backend (PHP - Composer)
```bash
composer install
```

### 🔐 Generar clave de aplicación
```bash
php artisan key:generate
```

### 🧬 Migraciones de la base de datos
```bash
php artisan migrate --seed

```

### 📁 Crear acceso público a archivos
```bash
php artisan storage:link
```

---

### 💻 4. Instalar dependencias del frontend

```bash
npm install
npm run dev   # Para desarrollo
npm run build # Para compilar en producción
```

---

### 📚 5. Instalar paquetes adicionales necesarios

```bash
composer require barryvdh/laravel-dompdf
composer require phpoffice/phpspreadsheet
composer require spatie/laravel-permission
composer require jeroennoten/laravel-adminlte
```

> ⚠️ Si `AdminLTE` ya estaba instalado previamente, no vuelvas a ejecutar `php artisan adminlte:install`, ya que puede sobrescribir vistas personalizadas.

---

### ✅ 6. Crear usuario y permisos

Si usás seeders para crear roles, permisos y un superusuario, podés correr:

```bash
php artisan db:seed
```

### 🚀 7. Levantar el servidor de desarrollo

```bash
php artisan serve
```


