# ID Card Generator

Laravel app to manage students, collect registrations, and print **student** or **parent** ID cards from one print module.

```text
Students  →  Registration  →  Print ID Cards
 (CRUD)      (photo+details)   (student / parent)
```

---

## Modules

| Module | Purpose |
|--------|---------|
| **Students** | Create, edit, delete, Excel import |
| **Registrations** | View completed registrations, reset, one-click print |
| **Print ID Cards** | Filter, select, bulk or single print (shared card template) |
| **Campuses** | Manage campuses (used in forms & cards) |
| **Classes** | Manage classes dynamically |
| **Public form** | `/registration` — students complete their details |

---

## Quick start

```bash
composer install
cp .env.example .env
php artisan key:generate
# configure DB in .env
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

**Demo login:** `admin@example.com` / `password`

---

## Easy printing

1. Open **Print ID Cards**
2. Filter by campus / class / search
3. Select students → **Print Student IDs** or **Print Parent IDs**
4. Or use the row icons for one-click single cards

Same card layout for both types — only the badge changes (`Student` / `Parent Copy`).

Also available from:
- Students list (when registered)
- Registrations list

---

## Customize

`config/idcard.php` or `.env`:

```env
IDCARD_ORG="Demo Academy"
IDCARD_TAGLINE="Student Identity Card"
```

Edit campuses and classes in `config/idcard.php`.

---

## Stack

Laravel 11 · Breeze · Spatie Permission · Yajra DataTables · Maatwebsite Excel · AdminLTE

---

## License

MIT
"# id-card-generator" 
