# Membership System with PHP & Stripe API

Este proyecto es un sistema de membresías en PHP que permite el registro de usuarios y el pago mediante Stripe. Una vez realizado el pago, el sistema activa la cuenta del usuario automáticamente usando un webhook.

## Características

- Registro de usuarios
- Inicio de sesión (sólo para cuentas activas)
- Integración con Stripe Checkout
- Webhook de Stripe que activa la cuenta tras el pago
- Sistema de sesiones
- Estructura MVC básica
- Variables de entorno con `.env`

## Requisitos

- PHP 7.4+
- MySQL
- Composer
- Cuenta en Stripe
- Servidor con acceso público para el webhook o uso de Stripe CLI

## Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/ErickDeps/Membership_system_with_PHP_-_Stripe-API.git
cd Membership_system_with_PHP_-_Stripe-API
```
