# UML Diagram Prompts for Login and Registration Use Case

## 📐 Sequence Diagram Prompt

```
Create a UML Sequence Diagram for the Login and Registration system with the following specifications:

**Actors:**
- User (Consumer/Guest)
- System (Laravel Backend)
- Database (MySQL)
- Email Service (Laravel Mail)
- Session Manager

**Registration Flow:**
1. User submits registration form with: name, nickname, email, birthday, gender, password
2. System validates input (email unique, password strength, required fields)
3. System hashes password using Laravel Hash
4. System creates user record in database with role='consumer'
5. Database returns user ID
6. System triggers "Registered" event
7. System auto-logs in user (creates session)
8. Session Manager stores authentication token
9. System sends verification email via Email Service
10. System redirects to email verification notice page
11. Return success message to User

**Login Flow:**
1. User submits login credentials (email + password)
2. System validates input format
3. System attempts authentication with credentials
4. Database queries user by email
5. System verifies hashed password
6. If credentials invalid: return error "credentials do not match"
7. If credentials valid: System regenerates session ID
8. System checks if email is verified
9. If not verified: keep logged in but redirect to verification notice
10. If verified: redirect to dashboard
11. Return success to User

**Alternative Flows:**
- Failed validation: return validation errors
- Email already exists: return error
- Password mismatch: return authentication error
- Unverified email: redirect to verification page

**Error Handling:**
- ValidationException caught and displayed
- AuthenticationException for invalid credentials
- Database errors logged and generic error shown

Keep the diagram clean, use standard UML notation, show all objects vertically aligned, use activation boxes for processing, and include alt/opt frames for conditional logic.
```

---

## 🔄 Activity Diagram Prompt

```
Create a UML Activity Diagram for the Login and Registration system with the following specifications:

**Registration Activity Flow:**

START (User visits registration page)
├─> Display Registration Form
├─> User fills form (name, nickname, email, birthday, gender, password, password_confirmation)
├─> User clicks "Register" button
├─> [Decision: Valid Input?]
    ├─ NO ─> Display Validation Errors ─> Back to Form
    └─ YES ─> Continue
├─> [Decision: Email Already Exists?]
    ├─ YES ─> Display "Email taken" error ─> Back to Form
    └─ NO ─> Continue
├─> Hash Password
├─> Create User in Database (role: consumer)
├─> Auto-Login User
├─> Create Session
├─> Send Verification Email (background)
├─> Redirect to Email Verification Notice
END

**Login Activity Flow:**

START (User visits login page)
├─> Display Login Form
├─> User enters email + password
├─> User clicks "Login" button
├─> [Decision: Valid Format?]
    ├─ NO ─> Display Validation Errors ─> Back to Form
    └─ YES ─> Continue
├─> Query User by Email
├─> [Decision: User Found?]
    ├─ NO ─> Display "Invalid credentials" ─> Back to Form
    └─ YES ─> Continue
├─> Verify Password Hash
├─> [Decision: Password Correct?]
    ├─ NO ─> Display "Invalid credentials" ─> Back to Form
    └─ YES ─> Continue
├─> Regenerate Session ID (security)
├─> Mark User as Authenticated
├─> [Decision: Email Verified?]
    ├─ NO ─> Redirect to Verification Notice (Stay logged in)
    └─ YES ─> Redirect to Dashboard
END

**Key Elements to Include:**
- Start node (filled circle)
- End node (filled circle with border)
- Activities (rounded rectangles)
- Decision diamonds with YES/NO branches
- Fork/Join bars (parallel processing for email)
- Merge nodes where branches reunite
- Flow arrows with labels
- Swimlanes for different responsibilities (User, System, Database, Email Service)

**Visual Guidelines:**
- Use 4 vertical swimlanes: User | System | Database | Email
- Keep flow top-to-bottom
- Label all decision points clearly
- Use different colors for success (green) and error (red) paths
- Show email sending as parallel fork (non-blocking)
- Group related activities with notes/comments
```

---

## 📊 Use Case Specification Details

### Use Case: User Registration

**ID:** UC-AUTH-001  
**Name:** User Registration  
**Actor:** Guest User  
**Precondition:** User is not authenticated  
**Postcondition:** User account created and logged in  

**Main Success Scenario:**
1. User navigates to registration page (`/register`)
2. System displays registration form
3. User enters name, email, password, and optional fields (nickname, birthday, gender)
4. User confirms password
5. User submits form
6. System validates all input fields
7. System checks email uniqueness
8. System hashes password using bcrypt
9. System creates user record with role='consumer'
10. System auto-authenticates user
11. System sends verification email
12. System redirects to email verification notice
13. Use case ends

**Extensions:**
- 6a. Validation fails
  - 6a1. System displays specific error messages
  - 6a2. User corrects input
  - 6a3. Return to step 5
- 7a. Email already registered
  - 7a1. System displays "email already taken" error
  - 7a2. Return to step 3
- 9a. Database error
  - 9a1. System logs error
  - 9a2. System displays generic error
  - 9a3. Use case fails

**Business Rules:**
- BR1: Default role is 'consumer'
- BR2: Email must be unique
- BR3: Password must meet Laravel default strength requirements
- BR4: Email verification required but not mandatory for login
- BR5: User auto-logged in after registration

---

### Use Case: User Login

**ID:** UC-AUTH-002  
**Name:** User Login  
**Actor:** Registered User  
**Precondition:** User has registered account  
**Postcondition:** User authenticated and redirected appropriately  

**Main Success Scenario:**
1. User navigates to login page (`/login`)
2. System displays login form
3. User enters email and password
4. User optionally checks "Remember Me"
5. User submits form
6. System validates input format
7. System queries database for user by email
8. System verifies password against stored hash
9. System regenerates session ID
10. System marks user as authenticated
11. System checks email verification status
12. IF verified: redirect to dashboard
13. IF not verified: redirect to verification notice (stay logged in)
14. Use case ends

**Extensions:**
- 6a. Validation fails
  - 6a1. System displays format errors
  - 6a2. Return to step 3
- 7a. Email not found
  - 7a1. System displays "credentials do not match"
  - 7a2. Return to step 3
- 8a. Password incorrect
  - 8a1. System displays "credentials do not match"
  - 8a2. Return to step 3
- 10a. Session creation fails
  - 10a1. System logs error
  - 10a2. System displays generic error
  - 10a3. Use case fails

**Business Rules:**
- BR6: User can login without email verification
- BR7: Unverified users redirected to verification notice
- BR8: Session regenerated on successful login (security)
- BR9: Remember Me creates persistent session
- BR10: Failed attempts not limited (can be added later)

---

## 🎯 Key System Components

**Controllers:**
- `RegisteredUserController.php` - Handles registration
- `AuthenticatedSessionController.php` - Handles login/logout

**Models:**
- `User.php` - User entity with roles (admin, consultant, consumer)

**Middleware:**
- `guest` - Ensures user not authenticated (for login/register pages)
- `auth` - Ensures user is authenticated
- `RoleMiddleware` - Checks user role permissions

**Database Tables:**
- `users` - Stores user accounts with fields:
  - id, name, nickname, email, birthday, gender, phone
  - password (hashed), role, email_verified_at
  - profile_picture, skin_type, skin_concerns, using_products
  - created_at, updated_at

**Routes:**
- GET `/register` - Show registration form
- POST `/register` - Process registration
- GET `/login` - Show login form
- POST `/login` - Process login
- POST `/logout` - Logout user

**Email Notifications:**
- `VerifyEmail` - Email verification link
- Implements Laravel `MustVerifyEmail` interface

---

## 💡 Tips for Diagram Creation

1. **For PlantUML users**, these prompts work well with Claude/ChatGPT to generate PlantUML code
2. **For Lucidchart/Draw.io**, use the textual description to manually create diagrams
3. **For Mermaid.js**, ask AI to convert these prompts to Mermaid syntax
4. **Key Focus:** Keep diagrams simple, avoid over-complication, focus on main flows
5. **Testing:** Verify diagrams match actual code implementation in the Laravel files

---

**Status:** Ready to use with any UML diagram tool or AI assistant
