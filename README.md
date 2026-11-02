# 🏢 ApexCorp - Company Web Portal (Employee & Admin Authentication)

![PHP](https://img.shields.io/badge/PHP-8.x-777bb4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-phpMyAdmin-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

A full-stack, responsive company webpage with front-end, back-end, and database integration featuring role-based authentication where:
- **Employee Login:** Authenticates and displays **all Administrator details** (Leadership & Executive Directory).
- **Admin Login:** Authenticates and displays **all Employee details** (Staff Roster & Personnel Directory).

---

## ✨ Features

- **Zero-Configuration Auto-Setup:** Automatically detects your MySQL port (`3306` or `3307`), creates the `company_db` database, sets up the `users` table, and seeds demo accounts on first page load!
- **Dual-Role Access Control:** Strict conditional views based on user session role.
- **Modern Corporate UI:** Clean typography (Plus Jakarta Sans & Inter), gradient badges, live system status pulse, and responsive layout.
- **Interactive Directory Tools:** Real-time search by name/email/designation, department filtering, 1-click CSV directory export, and full dossier popup modals.
- **Fast 1-Click Demo Login:** Dedicated buttons on the Home Page and Login Page to sign in instantly without typing.
- **Security:** Bcrypt password hashing (`PASSWORD_BCRYPT`), prepared SQL statements (`mysqli_prepare`), and session sanitization.

---

## 🔑 Demo Credentials

| Role | Email | Password | Access Rights |
| :--- | :--- | :--- | :--- |
| 👑 **Administrator** | `admin@apexcorp.com` | `Admin@123` | Authenticates & views **all Employee details** |
| 💼 **Employee** | `john.dev@apexcorp.com` | `Emp@123` | Authenticates & views **all Admin details** |
| 💼 **Employee (Design)** | `emma.design@apexcorp.com` | `Emp@123` | Authenticates & views **all Admin details** |

---

## 🚀 How to Run

### Method 1: One-Click Quick Run (Fastest - No Apache required!)
1. Ensure your MySQL service (e.g. from XAMPP or standalone MySQL) is running.
2. Double-click **`start_server.bat`** (Windows) or run in terminal:
   ```bash
   php -S localhost:8000
   ```
3. Your browser will open **http://localhost:8000** automatically!

---

### Method 2: Using XAMPP (Apache + phpMyAdmin)
1. Copy or clone this folder into your XAMPP root:
   ```
   C:\xampp\htdocs\company
   ```
2. Open **XAMPP Control Panel** and start **Apache** and **MySQL**.
3. Open your browser and navigate to:
   - **Website:** [http://localhost/company/index.php](http://localhost/company/index.php)
   - **Database (phpMyAdmin):** [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)

---

### Method 3: Running in VS Code
1. Open this project folder in **Visual Studio Code**.
2. Press **`Ctrl + Shift + B`** on your keyboard (or press **`F5`**).
3. The project will launch directly in **Microsoft Edge**!

---

## 📁 Project Structure

```
├── .vscode/               # VS Code tasks and launch debug configuration
├── assets/
│   ├── css/style.css      # Custom modern stylesheet
│   └── js/
│       ├── validation.js  # Real-time form validation
│       └── dashboard.js   # Live search filter, modal viewer & CSV exporter
├── includes/
│   ├── header.php         # Navigation bar and branding
│   └── footer.php         # Footer and global scripts
├── config.php             # Database connection, port auto-detection & auto-migration
├── index.php              # Company Home Page
├── login.php              # Login Authentication Page
├── register.php           # Staff Registration Form
├── dashboard.php          # Conditional Role Directory
├── logout.php             # Session termination
├── schema.sql             # SQL schema backup (for manual phpMyAdmin import)
├── setup.php              # Standalone installer / diagnostics
├── start_server.bat       # Windows 1-click built-in server launcher
├── start_server.sh        # Linux / macOS launcher
└── run.bat                # Interactive browser chooser
```

---

## 🐙 How to Upload this Project to GitHub

Run these commands in your project terminal:

```bash
# 1. Initialize git (if not already done)
git init

# 2. Add all project files
git add .

# 3. Create initial commit
git commit -m "Initial commit: Company Webpage with Employee & Admin Role Authentication"

# 4. Rename default branch to main
git branch -M main

# 5. Link your GitHub repository (replace with your GitHub repository URL)
git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPOSITORY_NAME.git

# 6. Push code to GitHub
git push -u origin main
```

---

## 📄 License
This project is open-source under the [MIT License](LICENSE).
