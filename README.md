# Elite Roleplay Website

A premium web portal for the Elite Roleplay community, featuring Steam/Discord authentication, application systems, and community resources.

## Features
- **Modern UI**: Dark-themed, responsive design with premium aesthetics.
- **Steam & Discord Integration**: Seamless authentication and linking.
- **Application System**: Automated whitelist applications with Discord webhook notifications.
- **Admin Dashboard**: Manage community settings and review applications.
- **SEO Optimized**: Built with modern web standards for better visibility.

## Setup Instructions

### Prerequisites
- PHP 7.4+
- MySQL/MariaDB
- Web server (Apache/Nginx)

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/elite-roleplay.git
   ```
2. Create a `.env` file in the root directory (use `.env.example` as a template):
   ```bash
   cp .env.example .env
   ```
3. Update the `.env` file with your database credentials and API keys.
4. Import the database schema:
   ```bash
   mysql -u youruser -p yourdb < setup_db.sql
   ```
5. Configure your web server to point to the project directory.

## Security Note
The `.env` file and sensitive configuration files are ignored by Git. Never share your actual credentials in public repositories.

## Credits
Built for the Elite Roleplay community.
