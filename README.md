# ZedMeme - Modern Meme Sharing Platform

ZedMeme is a modern, responsive PHP-based web application for sharing and discovering memes. Built with a clean, user-friendly interface and robust backend functionality.

![ZedMeme Screenshot](/screenshots/zedmeme-screenshot.png)

## ✨ Features

- 🚀 **User Authentication**
  - Secure registration and login system
  - Session management with PHP
  - Password hashing for security

- 📱 **Responsive Design**
  - Mobile-first approach
  - Smooth mobile menu with touch gestures
  - Optimized for all screen sizes

- 🖼️ **Meme Management**
  - Upload and share memes with ease
  - View trending and recent memes
  - Like and save your favorite memes

- 🎨 **Modern UI/UX**
  - Clean, minimalist design
  - Smooth animations and transitions
  - Intuitive navigation

## 🛠️ Prerequisites

- PHP 8.0 or higher
- MySQL 8.0 or higher
- Web server (Apache/Nginx) or PHP's built-in server
- Modern web browser with JavaScript enabled

## 🚀 Quick Start

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/zedmeme.git
   cd zedmeme
   ```

2. **Set up the database**
   ```sql
   CREATE DATABASE zedmeme;
   USE zedmeme;
   ```
   Import the SQL schema from `database/schema.sql`

3. **Configure the application**
   Copy `.env.example` to `.env` and update with your database credentials:
   ```env
   DB_HOST=localhost
   DB_NAME=zedmeme
   DB_USER=your_username
   DB_PASS=your_password
   ```

4. **Start the development server**
   ```bash
   php -S localhost:8000 -t public
   ```
   Open your browser and visit `http://localhost:8000`

## 🏗️ Project Structure

```
Zedmeme.com/
├── components/         # Reusable PHP components
│   ├── homePage/      # Homepage components
│   └── shared/        # Shared UI components
├── config/            # Configuration files
│   └── database.php   # Database configuration
├── css/               # Compiled CSS files
├── handler/           # Request handlers
├── js/                # JavaScript files
│   └── navbar.js      # Responsive navigation
├── pages/             # Page templates
├── uploads/           # User-uploaded memes
│   └── memes/         # Meme images
├── .env.example       # Environment config example
└── README.md          # This file
```

## 🌐 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile Safari (iOS 12+)
- Chrome for Android

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Built with PHP and MySQL
- Responsive design with modern CSS
- Mobile-first approach for better accessibility

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
