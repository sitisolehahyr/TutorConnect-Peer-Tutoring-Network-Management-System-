# TutorConnect · Peer Tutoring Network

TutorConnect is a portfolio-ready concept for managing a peer-to-peer tutoring programme. The refreshed UI showcases a modern student experience: explore subjects, meet tutors, book sessions, leave feedback, and grow a shared resource hub—all inside a clean, consistent design system.

## What’s inside

```
public/
├── index.html                # Landing page and product story
├── assets/
│   ├── css/main.css          # Shared design system (glassmorphism-inspired)
│   └── images/…              # Optimised image assets
├── api/                      # PHP endpoints for demo data flows
│   ├── database.php          # Connection helper + JSON responder
│   ├── login.php             # Student authentication endpoint
│   ├── register_student.php  # Student onboarding endpoint
│   └── create_appointment.php# Appointment booking endpoint
├── pages/                    # Feature screens
│   ├── appointments.html
│   ├── feedback.html
│   ├── resources.html
│   ├── student-profile.html
│   ├── tutor-dashboard.html
│   ├── tutors.html
│   ├── …
│   └── legacy/               # Original concept pages kept for reference
└── scripts/                  # Reserved for future front-end utilities

tools/
└── seed/seed_student_example.php  # Simple data seeding helper
```

## Highlights

- **Cohesive visual language** – gradient accents, glass surfaces, and responsive layouts shared through `assets/css/main.css`.
- **Streamlined flows** – new appointment booking, login, and signup screens feature inline validation and friendly feedback states.
- **Modular architecture** – front-end lives in `public/pages`, while PHP endpoints sit in `public/api` with reusable helpers.
- **Cleaner assets** – images renamed and organised under `public/assets/images` for predictable usage.
- **Legacy archive** – original static mock-ups live under `public/pages/legacy` so earlier work is still discoverable.

## Quick start

> Requirements: PHP 8+, MySQL (or MariaDB), and your favourite browser.

1. **Clone the repository**
   ```bash
   git clone https://github.com/sitisolehahyr/TutorConnect.git
   cd TutorConnect
   ```
2. **Configure the database connection**
   Create a `.env` file or export environment variables before running the PHP server:
   ```bash
   export DB_HOST=localhost
   export DB_USERNAME=root
   export DB_PASSWORD=secret
   export DB_DATABASE=tutorconnect_db
   ```
3. **Seed sample data (optional)**
   ```bash
   php tools/seed/seed_student_example.php
   ```
4. **Serve the experience**
   ```bash
   php -S 127.0.0.1:8000 -t public
   ```
   Visit <http://127.0.0.1:8000> to explore the interface. API endpoints are available under `/api/*`.

## Demo endpoints

| Endpoint | Method | Purpose |
| --- | --- | --- |
| `/api/register_student.php` | `POST` | Registers a new student profile with hashed credentials. |
| `/api/login.php` | `POST` | Validates username/password using `password_verify`. |
| `/api/create_appointment.php` | `POST` | Books a tutoring session and returns a confirmation payload. |

Each endpoint expects URL-encoded form data and responds with JSON. The helper in `database.php` reads connection details from environment variables and makes it easy to share consistent responses via `respond_json()`.

## Key screens

- `index.html` – hero landing page with product story, features, testimonials, and CTAs.
- `pages/subjects.html` – curated subject catalogue with quick actions.
- `pages/tutors.html` – tutor directory with refined cards and call-to-actions.
- `pages/appointments.html` – modern booking form with inline status messaging.
- `pages/resources.html` – resource hub featuring downloadable study kits.
- `pages/feedback.html` – feedback submission flow and themes overview.
- `pages/student-profile.html` / `pages/tutor-dashboard.html` – portfolio-friendly dashboards for each persona.

## Design & development notes

- **Styling:** Centralised in `assets/css/main.css`, featuring CSS variables, component-driven classes, and responsive breakpoints.
- **JavaScript:** Minimal, page-scoped scripts for login, signup, and appointment flows using `fetch` + optimistic UI updates.
- **Accessibility:** Landmarks (`header`, `main`, `footer`), descriptive alt text, and live regions for status updates.
- **Legacy mock-ups:** Unrefined originals are preserved in `public/pages/legacy`—useful if you want to show the before/after story.

## Roadmap ideas

1. Add a lightweight build step (Vite or Parcel) to bundle shared JS modules.
2. Replace PHP endpoints with a Laravel or Express API for production deployments.
3. Persist feedback and resources via dedicated tables, adding pagination and search.

## License

This project is released under the MIT License. See [LICENSE](LICENSE) for details.
