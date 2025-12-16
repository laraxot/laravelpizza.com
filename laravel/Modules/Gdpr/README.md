# GDPR Module Fila3 🔒 Your All-in-One GDPR Compliance Solution for Laravel 🚀

[![Latest Release](https://img.shields.io/github/v/release/laraxot/module_gdpr_fila3)](https://github.com/laraxot/module_gdpr_fila3/releases)
[![Build Status](https://img.shields.io/travis/laraxot/module_gdpr_fila3/master)](https://travis-ci.org/laraxot/module_gdpr_fila3)
[![Code Coverage](https://img.shields.io/codecov/c/github/laraxot/module_gdpr_fila3)](https://codecov.io/gh/laraxot/module_gdpr_fila3)
[![License](https://img.shields.io/github/license/laraxot/module_gdpr_fila3)](LICENSE)

# Module Gdpr
[![Latest Version on Packagist](https://img.shields.io/packagist/v/laraxot/module_gdpr_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_gdpr_fila3)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/laraxot/module_gdpr_fila3/run-tests?label=tests)](https://github.com/laraxot/module_gdpr_fila3/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/laraxot/module_gdpr_fila3/Check%20&%20fix%20styling?label=code%20style)](https://github.com/laraxot/module_gdpr_fila3/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laraxot/module_gdpr_fila3.svg?style=flat-square)](https://packagist.org/packages/laraxot/module_gdpr_fila3)

The **GDPR Fila3** module is designed to help developers and businesses comply with GDPR regulations. It provides tools and features to manage users' personal data, ensuring that it is processed securely and transparently.

## Prerequisites
- php v8+
- laravel
- **[Xot Module](https://github.com/laraxot/module_xot_fila3.git)** (Required)
- **[Tenant Module](https://github.com/laraxot/module_tenant_fila3.git)** (Required)
- **[UI Module](https://github.com/laraxot/module_ui_fila3.git)** (Required)

## Add Module to the Project Base
Inside the `laravel/Modules` folder:

**Module GDPR Fila3** is the ultimate solution for integrating GDPR compliance into your Laravel project. With powerful features to manage user data, consent requests, and access requests, this module helps you ensure your project is fully compliant with GDPR regulations, saving you time and effort. 🛡️

---

### Key Features 🌟
- **User Data Management**: Collect, store, and process user data in compliance with GDPR.
- **Consent Requests**: Manage and record user consent for data processing seamlessly.
- **Data Access & Deletion**: Handle user data requests (access, modification, deletion) with ease.
- **Compliance Reporting**: Generate GDPR compliance reports to stay on top of regulations.
- **Automatic Logging**: Log all data access and processing activities for compliance.

---

### Installation Guide 💻

1. **Install the module:**
    ```bash
    git submodule add https://github.com/laraxot/module_gdpr_fila3.git Gdpr
    ```

2. **Run Migrations:**
    ```bash
    php artisan module:migrate Gdpr
    ```

3. **Enable the module:**
    ```bash
    php artisan module:enable Gdpr
    ```

4. **Check Active Modules:**
    ```bash
    php artisan module:list
    ```

---

### Console Commands 🚀

Manage GDPR features directly from the terminal:

- **List GDPR Requests:**
    ```bash
    php artisan gdpr:list
    ```
    _View all active GDPR requests from users._

- **Generate Compliance Report:**
    ```bash
    php artisan gdpr:report
    ```
    _Generate a report for your GDPR compliance efforts._

- **Log Data Processing Activities:**
    ```bash
    php artisan gdpr:log <activity>
    ```
    _Automatically log data processing activities to ensure transparency._

---

### Configuration 🔧

Customize the module to fit your app's GDPR needs. Update configurations via `module_gdpr_fila3.php` to adapt logging, consent handling, and more.

---

### FAQ ❓

- **Q: How do I manage consent requests?**
  A: Consent requests can be created and tracked within the module. You can set custom policies for consent renewal and updates.

- **Q: Is logging data access automatic?**
  A: Yes! All user data access and processing are automatically logged and can be reviewed at any time.

---

### Author 👨‍💻

Developed and maintained by [Marco Sottana](https://github.com/marco76tv)  
📧 Email: marco.sottana@gmail.com

---

### License 📄

This package is open-sourced under the [MIT license](LICENSE).

---

Stay compliant and secure user trust with **Module GDPR Fila3**! 💥

## Verify the Module is Active
```bash
php artisan module:list
```
in caso abilitarlo
```bash
php artisan module:enable Gdpr
```

## Run the Migrations
```bash
php artisan module:migrate Gdpr
