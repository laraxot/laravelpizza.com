# 🚀 Kit de Herramientas de Automatización Git

[![PHPStan](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg?style=for-the-badge&logo=php&logoColor=white)](phpstan/ANALISI_MODULI_PHPSTAN.md)

## Requisitos del Sistema
- PHP 8.2 o superior
- Composer
- Node.js 18+ y npm
- MySQL 8.0+
- Git

## Instalación

### 1. Clonar el Repositorio
```bash
git clone https://github.com/your-username/project.git
cd project
```

### 2. Instalar Dependencias PHP
```bash
composer install
```

### 3. Instalar Dependencias Node.js
```bash
npm install
```

### 4. Configurar el Entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar la Base de Datos
Editar el archivo `.env` con las credenciales de la base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Ejecutar Migraciones
```bash
php artisan migrate
```

### 7. Instalar Módulos
```bash

# Instalar Laravel Modules
composer require nwidart/laravel-modules

# Publicar la configuración de módulos
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

# Agregar el módulo Xot
git remote add -f xot https://github.com/crud-lab/xot.git
git subtree add --prefix Modules/Xot xot main --squash
```

### 8. Compilar Assets
```bash
npm run dev
```

### 9. Iniciar Servidor de Desarrollo
```bash
php artisan serve
```

## Estructura del Proyecto

```
project/
├── app/
├── config/
├── database/
├── Modules/
│   ├── Core/
│   ├── Module1/
│   ├── Module2/
│   └── Xot/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
└── docs/
    ├── roadmap/
    └── packages/
```

## Módulos Principales

### Core
- Gestión de usuarios y autenticación
- Configuración del sistema
- Funcionalidad base

### Module1
- Funcionalidades específicas del módulo 1
- Gestión de datos
- Interfaz de usuario

### Module2
- Funcionalidades específicas del módulo 2
- Gestión de procesos
- Integraciones

### Xot
- Framework base para módulos
- Componentes reutilizables
- Funcionalidad común

## Documentación

La documentación completa está disponible en el directorio `docs/`:
- [Hoja de Ruta del Proyecto](roadmap/README.md)
- [Documentación de Paquetes](packages/README.md)

## Desarrollo

### Comandos Útiles
```bash

# Crear un nuevo módulo
php artisan module:make NombreModulo

# Generar componentes para un módulo
php artisan module:make-controller NombreControlador NombreModulo
php artisan module:make-model NombreModelo NombreModulo
php artisan module:make-migration create_table NombreModulo

# Ejecutar pruebas
php artisan test

# Actualizar dependencias
composer update
npm update
```

### Mejores Prácticas
- Seguir las convenciones PSR-4 para autoloading
- Usar namespaces correctos para módulos
- Documentar cambios en CHANGELOG.md
- Mantener pruebas actualizadas
- Verificar compatibilidad cross-browser

## Licencia
Este proyecto está bajo la licencia MIT. Ver el archivo [LICENSE](../../LICENSE) para más detalles.

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com)
[![Bash](https://img.shields.io/badge/Bash-4EAA25?style=for-the-badge&logo=gnu-bash&logoColor=white)](https://www.gnu.org/software/bash/)
[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)

> **⚠️ ADVERTENCIA: Este kit de herramientas está diseñado para desarrolladores experimentados que trabajan con repositorios Git complejos y estructuras monorepo.**

## 🤔 ¿Por qué este kit de herramientas?

El desarrollo de un proyecto modular complejo presenta desafíos únicos:

- **Gestión de docenas de módulos interdependientes** que necesitan mantenerse sincronizados
- **Necesidad de colaboración** entre equipos distribuidos en diferentes repositorios
- **Mantenimiento de la consistencia** del código a través de múltiples ramas y organizaciones
- **Reducción del riesgo de errores manuales** en operaciones Git complejas
- **Automatización de procesos repetitivos** para aumentar la productividad
- **Soporte para análisis estático** con PHPStan Level 9

Este kit de herramientas aborda estos desafíos proporcionando herramientas automatizadas que simplifican el flujo de trabajo y garantizan consistencia y calidad.

## Traducciones
- [English](../../README.md)

# 🚀 Kit de Herramientas de Automatización Git

[![PHPStan](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg?style=for-the-badge&logo=php&logoColor=white)](phpstan/ANALISI_MODULI_PHPSTAN.md)

## Requisitos del Sistema
- PHP 8.2 o superior
- Composer
- Node.js 18+ y npm
- MySQL 8.0+
- Git

## Instalación

### 1. Clonar el Repositorio
```bash
git clone https://github.com/your-username/project.git
cd project
```

### 2. Instalar Dependencias PHP
```bash
composer install
```

### 3. Instalar Dependencias Node.js
```bash
npm install
```

### 4. Configurar el Entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar la Base de Datos
Editar el archivo `.env` con las credenciales de la base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Ejecutar Migraciones
```bash
php artisan migrate
```

### 7. Instalar Módulos
```bash

# Instalar Laravel Modules
composer require nwidart/laravel-modules

# Publicar la configuración de módulos
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

# Agregar el módulo Xot
git remote add -f xot https://github.com/crud-lab/xot.git
git subtree add --prefix Modules/Xot xot main --squash
```

### 8. Compilar Assets
```bash
npm run dev
```

### 9. Iniciar Servidor de Desarrollo
```bash
php artisan serve
```

## Estructura del Proyecto

```
project/
├── app/
├── config/
├── database/
├── Modules/
│   ├── Core/
│   ├── Module1/
│   ├── Module2/
│   └── Xot/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
└── docs/
    ├── roadmap/
    └── packages/
```

## Módulos Principales

### Core
- Gestión de usuarios y autenticación
- Configuración del sistema
- Funcionalidad base

### Module1
- Funcionalidades específicas del módulo 1
- Gestión de datos
- Interfaz de usuario

### Module2
- Funcionalidades específicas del módulo 2
- Gestión de procesos
- Integraciones

### Xot
- Framework base para módulos
- Componentes reutilizables
- Funcionalidad común

## Documentación

La documentación completa está disponible en el directorio `docs/`:
- [Hoja de Ruta del Proyecto](roadmap/README.md)
- [Documentación de Paquetes](packages/README.md)

## Desarrollo

### Comandos Útiles
```bash

# Crear un nuevo módulo
php artisan module:make NombreModulo

# Generar componentes para un módulo
php artisan module:make-controller NombreControlador NombreModulo
php artisan module:make-model NombreModelo NombreModulo
php artisan module:make-migration create_table NombreModulo

# Ejecutar pruebas
php artisan test

# Actualizar dependencias
composer update
npm update
```

### Mejores Prácticas
- Seguir las convenciones PSR-4 para autoloading
- Usar namespaces correctos para módulos
- Documentar cambios en CHANGELOG.md
- Mantener pruebas actualizadas
- Verificar compatibilidad cross-browser

## Licencia
Este proyecto está bajo la licencia MIT. Ver el archivo [LICENSE](../../LICENSE) para más detalles.

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com)
[![Bash](https://img.shields.io/badge/Bash-4EAA25?style=for-the-badge&logo=gnu-bash&logoColor=white)](https://www.gnu.org/software/bash/)
[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)

> **⚠️ ADVERTENCIA: Este kit de herramientas está diseñado para desarrolladores experimentados que trabajan con repositorios Git complejos y estructuras monorepo.**

## 🤔 ¿Por qué este kit de herramientas?

El desarrollo de un proyecto modular complejo presenta desafíos únicos:

- **Gestión de docenas de módulos interdependientes** que necesitan mantenerse sincronizados
- **Necesidad de colaboración** entre equipos distribuidos en diferentes repositorios
- **Mantenimiento de la consistencia** del código a través de múltiples ramas y organizaciones
- **Reducción del riesgo de errores manuales** en operaciones Git complejas
- **Automatización de procesos repetitivos** para aumentar la productividad
- **Soporte para análisis estático** con PHPStan Level 9

Este kit de herramientas aborda estos desafíos proporcionando herramientas automatizadas que simplifican el flujo de trabajo y garantizan consistencia y calidad.

## Traducciones
- [English](../../README.md)

