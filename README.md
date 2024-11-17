# PHP-GuestBook

A lightweight guestbook application written in native PHP, developed with object-oriented programming principles.

---

## Features

### Frontend
- **User Registration**:
  - Users can register an account.
  - Includes a **captcha** for registration to prevent spam.
- **User Login and Logout**:
  - Users can log in to their accounts and log out securely.
- **Leave a Comment**:
  - Authenticated users can leave comments.
- **Display Comments**:
  - Comments are displayed with associated metadata such as:
    - Author's name
    - Author's avatar
    - Date and time of the comment

---

### Backend
#### For Regular Users
- **Change Password**:
  - Allows users to update their passwords.
- **Avatar Upload**:
  - Users can upload a custom avatar.

#### For Administrators
- **User Management**:
  - Manage all user accounts, including:
    - Modify username, password, role (level), or avatar.
    - Delete user accounts.
  - Includes **pagination** for managing large numbers of users.
- **Comment Management**:
  - Manage all comments, including:
    - Modify comment content or publishing date.
    - Delete comments.
  - Includes **pagination** for managing large numbers of comments.

---

## Technical Highlights
1. **Object-Oriented Programming**:
   - All features are implemented using OOP principles, ensuring code reusability and scalability.
   
2. **Native PHP**:
   - Developed without using external frameworks, focusing on PHP core features.

3. **Clean Separation of Concerns**:
   - Clear distinction between frontend (HTML, CSS) and backend logic (PHP).

4. **Security Measures**:
   - Captcha for user registration to prevent bot sign-ups.
   - User authentication and session management.

5. **Responsive Design**:
   - Integrated with Bootstrap for a responsive and user-friendly interface.

---

## Use Cases
1. **Personal Projects**:
   - A great starting point for those learning PHP and web development.
2. **Small Websites**:
   - Can be deployed on small websites to provide a basic guestbook functionality.
3. **Learning Resource**:
   - Understand concepts of object-oriented programming, database interactions, and user authentication.

---

## Future Improvements
- **Add Rich Text Editor**:
  - Improve user experience for writing comments by integrating a rich text editor like TinyMCE or CKEditor.
- **Enhance Security**:
  - Implement hashed passwords with `password_hash` and `password_verify` instead of MD5.
  - Introduce CSRF tokens for form submissions.
- **Mobile Optimizations**:
  - Further optimize for small screens with custom media queries.
- **Improved Search**:
  - Add search functionality for comments and users.

---