# 🚀 Laravel Heizreport API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mapo-89/laravel-heizreport-api.svg?style=flat-square)](https://packagist.org/packages/mapo-89/laravel-heizreport-api)
[![Total Downloads](https://img.shields.io/packagist/dt/mapo-89/laravel-heizreport-api.svg?style=flat-square)](https://packagist.org/packages/mapo-89/laravel-heizreport-api)
![GitHub Actions](https://github.com/mapo-89/laravel-heizreport-api/actions/workflows/main.yml/badge.svg)

Eine einfache Laravel-Integration für die [Heizreport API](https://heizreport.com/hilfethemen/schnittstellen). Dieses Paket stellt dir eine saubere Schnittstelle zur Verfügung, um mit der API zu interagieren.

📖 Diese README ist auch auf [🇬🇧 Englisch](README.md) verfügbar.

---

## 📦 Installation

Installiere das Paket über Composer:

```bash
composer require mapo-89/laravel-heizreport-api
```

Füge deinen API-Token in deine `.env`-Datei ein:

```env
HEIZREPORT_API_TOKEN=your-token-here
```

Alternativ kannst du den Token dynamisch laden, z. B. aus einer Datenbank. Im `AppServiceProvider` innerhalb der `boot()`-Methode:

```php
use Illuminate\Support\Facades\Config;
use App\Models\Integration;

public function boot()
{
    Config::set('heizreport-api.api_token', Integration::getApiToken('Heizreport'));
}
```

Optional: Veröffentliche die Konfigurationsdatei:

```bash
php artisan vendor:publish --provider="Mapo89\LaravelHeizreportApi\HeizreportApiServiceProvider" --tag="config"
```

---

## ⚙️ Verwendung

```php
use Mapo89\LaravelHeizreportApi\Facades\HeizreportApi;

// Beispiel: Abrufen von allen Projekten
$data = HeizreportApi::make()->projects()->all(); // passe das an deinen Anwendungsfall an
```

> 📚 Die vollständige API-Dokumentation findest du hier: [heizreport.com](https://heizreport.com/hilfethemen/schnittstellen)

---

## ✅ Tests

```bash
composer test
```

---

## 📒 Changelog

Alle Änderungen findest du im [CHANGELOG](CHANGELOG.md).

---

## 🤝 Mitwirken

Beiträge sind herzlich willkommen! Details findest du in der [CONTRIBUTING](CONTRIBUTING.md)-Datei.

---

## 🔐 Sicherheit

Wenn du sicherheitsrelevante Probleme entdeckst, melde dich bitte **nicht** über den Issue Tracker, sondern direkt per E-Mail an [info@postler.de](mailto:info@postler.de).

---

## 👥 Credits

- [Manuel Postler](https://github.com/mapo-89)  
- [Alle Mitwirkenden](../../contributors)

---

## 📄 Lizenz

Dieses Paket steht unter der [MIT Lizenz](LICENSE.md).

---

## 🛠️ Boilerplate

Erstellt mit dem [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
