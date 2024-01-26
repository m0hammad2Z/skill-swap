# SkillSwap

SkillSwap is a platform that connects users based on their skills, allowing them to share knowledge through virtual rooms and video sessions.

## Table of Contents

- [Features](#features)
- [Technologies](#technologies)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

## Features

- **User Profiles**: Users can create and update their profiles with information such as skills, bio, and profile pictures.
- **Room Creation**: Users can create virtual rooms focused on specific skills they want to learn or teach.
- **Video Sessions**: Integration with a video session API for hosting interactive sessions within rooms.
- **Booking System**: Users can book sessions in rooms, and the status of bookings is tracked.
- **Notifications**: Users receive notifications about room activities and updates.
- **SBuck Monetization**: A virtual currency (SBuck) system that users can earn and spend within the platform.
- **Skill Suggestions**: Real-time skill suggestions using an AI API.
- **Chat System (Optional)**: Integration with a chat system implemented using Java, Spring WebSocket, and MongoDB.

## Technologies

- **Frontend**: HTML, CSS, JavaScript (Vue.js)
- **Backend**: PHP (Laravel)
- **Database**: MySQL
- **Video Sessions**: [Video Session API]
- **Chat System (Optional)**: Java, Spring WebSocket, MongoDB

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/SkillSwap.git
    ```

2. Install dependencies
   ```bash
   composer install
    ```
3. Set up your environment variables:
```bash
cp .env.example .env
```
Update the .env file with your database and other configuration details.

4. php artisan migrate
   ```bash
   php artisan migrate
   ```
5. Start the development server:
```bash
php artisan serve
```
## Usage
- Register an account, create a profile, and explore rooms based on your skills and interests.
- Create your own virtual rooms or join existing ones.
- Book video sessions, earn SBucks, and engage with the community.


## License
This project is licensed under the MIT License.
