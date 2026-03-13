# 💉 VaccTrack — Pediatric Vaccine Tracker

A full-featured pediatric vaccine management system built with **Laravel 11** and **SQLite**.

---

## 🚀 Quick Start

### Requirements
- PHP 8.1+
- Composer
- SQLite3 (built into PHP usually)

### Installation

```bash
# 1. Extract / clone project
cd vacctrack

# 2. Run the setup script (does everything)
bash setup.sh

# 3. Start the server
php artisan serve
```

Visit **http://localhost:8000**

---

## 🔑 Demo Credentials

| Role   | Username | Password |
|--------|----------|----------|
| Doctor | `admin`  | `admin`  |
| Parent | `parent` | `parent` |
| Parent | `parent2`| `parent` |
| Parent | `parent3`| `parent` |

---

## ✨ Features

### 🩺 Doctor Dashboard
- **Dashboard** — Stat cards, interactive calendar, quick actions, upcoming schedule
- **Vaccines** — Add / edit / delete vaccines with stock, price, category, manufacturer, active toggle
- **Children** — Register new children (with parent), register with existing parent, first vaccine at registration, view & edit profiles
- **Schedules** — Create appointments, update status, SMS log (auto + manual send), delete
- **Payments** — Process cash payments, view details, print invoices, print full report
- **Reports** — Generate vaccination, inventory, financial, and children reports with date filters; print-ready

### 👨‍👩‍👧 Parent Portal
- View all their children's profiles
- View upcoming & past schedules
- View vaccination records history
- View payment history

---

## 🗄️ Database Schema

| Table              | Description                        |
|--------------------|------------------------------------|
| `users`            | Doctor / staff accounts            |
| `parent_guardians` | Parent accounts + portal login     |
| `children`         | Patient records                    |
| `vaccines`         | Vaccine inventory                  |
| `schedules`        | Appointments                       |
| `vaccine_records`  | Administered vaccine history       |
| `payments`         | Cash payment records               |
| `sms_logs`         | SMS reminder log (simulated)       |
| `sessions`         | Laravel sessions                   |
| `cache`            | Laravel cache                      |

---

## 🛠️ Project Structure

```
vacctrack/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # AuthController, VaccineController, etc.
│   │   └── Middleware/      # DoctorAuth, ParentAuth
│   └── Models/              # All Eloquent models
├── database/
│   ├── migrations/          # All table migrations
│   ├── seeders/             # Demo data seeder
│   └── database.sqlite      # SQLite database (auto-created)
├── resources/views/
│   ├── auth/                # Login page
│   ├── layouts/             # app, doctor, parent layouts
│   ├── doctor/              # All doctor pages
│   └── parent/              # All parent pages
├── routes/web.php           # All routes
├── .env.example
└── setup.sh                 # One-command setup
```

---

## 💡 Notes

- **SMS** integration with [PhilSMS](https://philsms.com/) is configured. Messages are logged in the `sms_logs` table and displayed in the Schedules page.
- **Payments** are cash-only per clinic requirements.
- To reset demo data: `php artisan migrate:fresh --seed`
 
