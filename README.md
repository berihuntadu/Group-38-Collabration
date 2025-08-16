# Group38 Voting Website Project

A secure, user-friendly web application designed to allow citizens to register, log in, vote for candidates, and view election results. This system provides a unified environment where voters can participate safely and efficiently, while administrators can manage elections and monitor voting in real-time.

## Table of Contents
- [Project Overview](#project-overview)
- [Project Objectives](#project-objectives)
- [Challenges](#challenges)
- [Architectural Overview](#architectural-overview)
- [Technology Stack](#technology-stack)
- [Project Progress](#project-progress)
- [Contributors](#contributors)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)
- [References](#references)

## Project Overview
The Voting Website addresses the need for a secure, transparent, and accessible platform for elections. It allows citizens to cast votes safely, ensures only one vote per person, and provides administrators with tools to manage elections and display live results.

## Project Objectives
1. **Secure Voting System**  
   Implement a system where each voter can vote once and votes are recorded securely.

2. **User-Friendly Interface**  
   Easy-to-use interface for voters and administrators to navigate and complete tasks.

3. **Real-Time Results**  
   Display live election results while maintaining data integrity and security.

4. **Accessibility**  
   Ensure all eligible citizens can participate, including features for guidance like “How to Vote”.

5. **Admin Control**  
   Enable election monitoring, candidate management, and dispute resolution.

## Challenges
- **Security & Data Integrity:** Ensuring votes are safe from tampering and user data is protected.  
- **User Verification:** Accurate verification to prevent multiple votes per person.  
- **Accessibility & Guidance:** Providing clear instructions for all users, including those unfamiliar with digital voting.  
- **Scalability:** Supporting many simultaneous users during elections.  

## Architectural Overview
The project uses a **client-server architecture**:
- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** Flask (Python)  
- **Database:** SQLite/MySQL (depending on deployment)  
- **Optional Deployment:** Docker for containerization and easier deployment  

## Technology Stack
- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** Python (Flask)  
- **Database:** SQLite/MySQL  
- **Security:** JWT Authentication, password hashing, role-based access control  
- **Architecture:** Monolithic with modular backend structure  

## Project Progress

| Feature / Module | Status | Notes |
|-----------------|--------|-------|
| User Registration & Login | Completed | Secure login with password hashing and JWT authentication |
| Voting System | Completed | One vote per user, vote recorded securely |
| How to Vote Page | Completed | Step-by-step guidance for users |
| Live Results Display | Working | Real-time display of results |
| Admin Panel | In Progress | Candidate management and monitoring underway |
| Security Enhancements | Planned | Additional encryption and audit logging planned |

## Contributors
- **birtukan and naol** – Backend Development (Flask & Security & database)  
- **berihun and kena** – Frontend Development (HTML, CSS, JS)  

 ##  Usage

Access the frontend at http://localhost:5000 

Register and log in as a user to vote

Admins log in to manage elections and view results

## License

This project is licensed under the MIT License.

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-org/voting-website.git
   cd voting-website


 Contact
Team Lead:berihun tadu
phone number 0955767758

Email: youberihuntadu@gmail.com



