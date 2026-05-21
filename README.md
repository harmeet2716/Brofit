# FitNexus

FitNexus is a state-of-the-art, premium, and minimalist personal fitness & health management portal. Built with **Laravel 12**, **Vite (TailwindCSS)**, **MongoDB (Atlas)**, and integrated with **OpenAI / OpenRouter AI Coaches**. 

Featuring a solid, high-contrast **Forest Green & Off-Black minimalist aesthetic** with sharp square borders, zero clutter, and instantaneous transitions.

---

## Key Features

*   **Dynamic Fitness Dashboard**: Live streak trackers, daily task progress calculators, and workout completion summaries.
*   **Premium Course Syllabus**: Surf through available HIIT, Strength, and Yoga programs with fully featured enrollment systems.
*   **target Exercise Library**: Complete muscular breakdown of target exercises with seamless options to add them to daily tracker cards.
*   **Calorie & Nutrition Portal**: Log food grams, monitor macronutrient percentages (Protein / Carbs / Fat), and estimate calories burned.
*   **Dynamic AI Fitness Coach**: Real-time chat advisor that dynamically auto-detects and supports both standard **OpenAI API keys** and **OpenRouter API Keys** to generate detailed 7-day personalized workout & meal regimens.
*   **Self-Healing & Robust**: Implements absolute offline database-safe fallbacks. If MongoDB is offline, unseeded, or missing, the entire application gracefully degrades to high-fidelity mock previews so the portal remains completely surfable!

---

## Contributor Setup & Installation

To run this project locally and collaborate with the team, follow these simple setup steps:

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/fitnexus.git
cd fitnexus
```

### 2. Install Project Dependencies
Run both composer and node packages installers:
```bash
composer install
npm install
```

### 3. Setup Your Environment File
Create a new `.env` file by copying the template:
```bash
cp .env.example .env
```
Open the `.env` file and generate a secure application key:
```bash
php artisan key:generate
```

### 4. Configure Database & AI Key
Edit your `.env` file to provide your database connection credentials and AI API keys:

*   **Database (MongoDB Atlas Cloud or Local)**:
    ```ini
    DB_CONNECTION=mongodb
    MONGODB_URI=your_mongodb_connection_uri_here
    MONGODB_DATABASE=fitnexus
    ```
*   **AI Coach API Key (OpenAI or OpenRouter)**:
    ```ini
    # Standard OpenAI keys or OpenRouter keys (sk-or-...) are both supported!
    OPENAI_API_KEY=your_api_key_here
    ```

### 5. Run Database Migrations & Seeds
Prepare the database schemas and automatically seed all premium courses, target exercises, and default accounts:
```bash
php artisan migrate
php artisan db:seed
```
*Note: The default credentials for the seeded Demo account are `demo@fitportal.com` / `password`.*

### 6. Compile Styling Assets
Compile assets in development or build them for production:
```bash
# Compile and hot reload
npm run dev

# Or build static assets
npm run build
```

### 7. Launch local server
Start the local PHP Artisan development server:
```bash
php artisan serve
```
Open **`http://127.0.0.1:8000`** in your browser and enjoy **FitNexus**!

---

## Architectural highlights

*   **Self-Healing Key Detection**: Inside [AiCoachController.php](app/Http/Controllers/AiCoachController.php), the engine dynamically scans your `OPENAI_API_KEY` format. If it detects an OpenRouter key (`sk-or-`), it reroutes requests to the OpenRouter gateway and injects the required title/referrer headers automatically.
*   **Zero-Crash BSON Key Normalizer**: Integrates BSON primary key handlers in controllers to map database `id` BSON objects and `_id` template parameters uniformly, ensuring 100% template compatibility.
*   **Universal Square Borders & Minimalist Palette**: Enabled globally via universal CSS rules inside [app.css](resources/css/app.css) to override default styling templates, ensuring an extremely sleek, high-contrast, professional forest green palette.
