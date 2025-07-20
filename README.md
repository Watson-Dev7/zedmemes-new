# ZedMeme - Meme Sharing Platform

ZedMeme is a PHP-based web application that allows users to share and view memes in real-time. The platform includes user authentication, meme uploads, and a responsive design built with Foundation CSS framework.

## Features

- User registration and authentication
- Meme upload and display
- Real-time updates using Server-Sent Events (SSE)
- Responsive design with Foundation CSS
- User profile management
- Like and interact with memes

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP's built-in development server
- Composer (for dependency management)
- Node.js and npm (for frontend assets)

## Installation

1. Clone the repository:
   ```bash
   git clone [repository-url].git
   cd Zedmeme.com
   ```

2. Set up the database:
   - Create a new MySQL database
   - Import the database schema from `database/schema.sql`
   - Copy `.env.example` to `.env` and update the database credentials

3. Install PHP dependencies:
   ```bash
   composer install
   ```

4. Configure the application:
   - Update the database connection settings in `config/database.php`
   - Set up your web server to point to the `public` directory

5. Start the development server:
   ```bash
   php -S localhost:8000 -t public
   ```

## Project Structure

```
Zedmeme.com/
├── components/         # Reusable UI components
├── config/            # Configuration files
├── foundation/        # Frontend assets (CSS/JS)
├── handler/           # PHP request handlers
├── images/            # Uploaded memes
├── pages/             # Page templates
├── public/            # Publicly accessible files
├── .env.example       # Environment configuration example
├── composer.json      # PHP dependencies
└── README.md          # This file
```

## Features in Detail

### User Authentication
- Secure login/signup system
- Session management
- Password hashing

### Meme Management
- Upload and share memes
- View meme feed
- Like functionality
- Real-time updates

### Frontend
- Responsive design with Foundation CSS
- Interactive UI components
- Client-side form validation

## API Endpoints

- `POST /handler/auth-handler.php` - Handle user authentication
- `POST /handler/upload.php` - Handle meme uploads
- `GET /finalSendData.php` - SSE endpoint for real-time updates

## Development

### Frontend Development
- Edit files in the `foundation/` directory
- CSS is compiled using SASS
- JavaScript modules are bundled using Webpack

### Backend Development
- Follow PSR-4 autoloading standards
- Use prepared statements for database queries
- Keep business logic separate from presentation

## Environment Variables

Copy `.env.example` to `.env` and update the values:

```
DB_HOST=localhost
DB_NAME=zedmeme
DB_USER=root
DB_PASS=

APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Built with PHP and MySQL
- Frontend powered by Foundation CSS
- Real-time updates with Server-Sent Events
- Icons from [Font Awesome](https://fontawesome.com/)

## Support

For support, email support@zedmeme.com or open an issue in the GitHub repository.
