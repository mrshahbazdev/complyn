# COMPLYN

Modulare Compliance-Plattform für den deutschen Mittelstand.

## Struktur

Plattform → Block → Modul. Jedes Modul hat eigene Routen, Datenbanktabellen,
Berechtigungen und Views und kann pro Tarif (Plan) an-/abgeschaltet werden.

- `config/blocks.php` — Quell-of-Truth: Blöcke und Module (Deutsch + English)
- `platform:sync-modules` — spiegelt die Config in `platform_modules`
- **Blöcke:** Admin, Core, Coach, Community, Score, Connect, Docs, Library, Creator, Academy, Exchange

## Phase 0 — Plattform-Foundation

- Laravel 12, nwidart/laravel-modules, Sanctum, spatie/laravel-permission (Teams = Company)
- Multi-Tenant: `companies` ↔ `company_user` (owner/admin/member)
- Pläne: `plans` ↔ `plan_modules`; Firmen-Overrides: `company_modules`
- DE-first i18n (`lang/de`, EN fallback)
- Shared Services: `AiService` (Provider/Prompts/Limits in `config/ai.php`), `StorageService`, `HasTags`
- MCP-API (`/api/mcp/*`): Bearer-Tokens (`cpn_…`) mit Scopes read/content/full, Audit-Log, Artisan-Allow-List

## Setup

```bash
composer install
cp .env.example .env && php artisan key:generate
# .env: MySQL-Zugang setzen (DB_*), QUEUE_CONNECTION=database
php artisan migrate --seed   # seeded Pläne + Module
php artisan serve
```

## MCP-Token ausstellen

```php
[$token, $plain] = McpToken::issue('name', 'full'); // read|content|full
```

Authorization: `Bearer cpn_…` — jede Aktion landet in `mcp_audit_logs`.

## Tests

```bash
php artisan test
```
