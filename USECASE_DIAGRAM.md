# CeraVe System - Use Case Diagram

## System Overview

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                          CERAVE SKINCARE SYSTEM                                 │
│                                                                                 │
│  ┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐             │
│  │     Guest        │  │  Authenticated   │  │  Admin/          │             │
│  │     User         │  │  User            │  │  Consultant      │             │
│  └────────┬─────────┘  └────────┬─────────┘  └────────┬─────────┘             │
│           │                     │                      │                       │
│           └─────────────────────┼──────────────────────┘                       │
│                                 │                                              │
│  ╔═════════════════════════════════════════════════════════════════════════╗  │
│  ║                                                                         ║  │
│  ║                        Main System Features                           ║  │
│  ║                                                                         ║  │
│  ║  ┌──────────────────────────────────────────────────────────────────┐  ║  │
│  ║  │                      PRODUCTS MODULE                            │  ║  │
│  ║  │  ◇ Browse Products                                             │  ║  │
│  ║  │  ◇ View Product Details                                        │  ║  │
│  ║  │  ◇ Search Products                                             │  ║  │
│  ║  │  ◇ Create Reviews                                              │  ║  │
│  ║  │  ◇ View Reviews & Comments                                     │  ║  │
│  ║  │  ◇ Manage Reviews (Edit/Delete)                                │  ║  │
│  ║  │  ◇ Reply to Reviews (Admin/Consultant)                         │  ║  │
│  ║  │  ◇ Create/Edit/Delete Products (Admin Only)                    │  ║  │
│  ║  └──────────────────────────────────────────────────────────────────┘  ║  │
│  ║                                                                         ║  │
│  ║  ┌──────────────────────────────────────────────────────────────────┐  ║  │
│  ║  │                    DR. C AI CHATBOT MODULE                       │  ║  │
│  ║  │  ◇ Chat with Dr. C (AI Skincare Advisor)                        │  ║  │
│  ║  │  ◇ Get Product Recommendations                                  │  ║  │
│  ║  │  ◇ View Chat History                                            │  ║  │
│  ║  │  ◇ View Sessions & Reports                                      │  ║  │
│  ║  │  ◇ End Session                                                  │  ║  │
│  ║  │  ◇ Delete Messages (Admin Only)                                 │  ║  │
│  ║  │  ◇ Manage All Sessions (Admin Only)                             │  ║  │
│  ║  └──────────────────────────────────────────────────────────────────┘  ║  │
│  ║                                                                         ║  │
│  ║  ┌──────────────────────────────────────────────────────────────────┐  ║  │
│  ║  │                  APPOINTMENTS MODULE                            │  ║  │
│  ║  │  ◇ Create Appointment                                           │  ║  │
│  ║  │  ◇ View My Appointments                                         │  ║  │
│  ║  │  ◇ Update Appointment Status                                    │  ║  │
│  ║  │  ◇ Delete Appointment                                           │  ║  │
│  ║  │  ◇ Manage Appointments (Admin/Consultant)                       │  ║  │
│  ║  │  ◇ Submit Consultation Report (Consultant)                      │  ║  │
│  ║  │  ◇ Approve Report (Admin Only)                                  │  ║  │
│  ║  │  ◇ View Analytics & Reports (Admin/Consultant)                  │  ║  │
│  ║  │  ◇ Export Reports (Admin/Consultant)                            │  ║  │
│  ║  │  ◇ Receive Appointment Notifications                            │  ║  │
│  ║  └──────────────────────────────────────────────────────────────────┘  ║  │
│  ║                                                                         ║  │
│  ║  ┌──────────────────────────────────────────────────────────────────┐  ║  │
│  ║  │                    AUTHENTICATION MODULE                         │  ║  │
│  ║  │  ◇ Register Account                                             │  ║  │
│  ║  │  ◇ Login                                                        │  ║  │
│  ║  │  ◇ OAuth Login (Google)                                         │  ║  │
│  ║  │  ◇ Verify Email                                                │  ║  │
│  ║  │  ◇ Reset Password                                               │  ║  │
│  ║  │  ◇ Logout                                                       │  ║  │
│  ║  └──────────────────────────────────────────────────────────────────┘  ║  │
│  ║                                                                         ║  │
│  ║  ┌──────────────────────────────────────────────────────────────────┐  ║  │
│  ║  │                      PROFILE MODULE                             │  ║  │
│  ║  │  ◇ View Profile                                                 │  ║  │
│  ║  │  ◇ Edit Profile Information                                     │  ║  │
│  ║  │  ◇ Update Password                                              │  ║  │
│  ║  │  ◇ Update Email                                                 │  ║  │
│  ║  │  ◇ Delete Account                                               │  ║  │
│  ║  │  ◇ View Public Profile (Other Users)                            │  ║  │
│  ║  └──────────────────────────────────────────────────────────────────┘  ║  │
│  ║                                                                         ║  │
│  ║  ┌──────────────────────────────────────────────────────────────────┐  ║  │
│  ║  │                    ADMIN DASHBOARD MODULE                       │  ║  │
│  ║  │  ◇ Manage Settings                                              │  ║  │
│  ║  │  ◇ Configure Site Content                                       │  ║  │
│  ║  │  ◇ View System Analytics                                        │  ║  │
│  ║  │  ◇ Manage Users & Roles                                         │  ║  │
│  ║  │  ◇ View Activity Log                                            │  ║  │
│  ║  └──────────────────────────────────────────────────────────────────┘  ║  │
│  ║                                                                         ║  │
│  ╚═════════════════════════════════════════════════════════════════════════╝  │
│                                                                                 │
└─────────────────────────────────────────────────────────────────────────────────┘
```

## Detailed Use Case Descriptions

### 1. PRODUCTS MODULE
| Use Case | Actor | Description |
|----------|-------|-------------|
| Browse Products | Guest, User | View all available CeraVe products in a paginated list |
| View Product Details | Guest, User | View detailed information about a specific product (description, images, features, reviews) |
| Search Products | Guest, User | Search products by name, ingredient, or concern |
| Create Review | User | Submit a review for a product with rating and comments |
| View Reviews | Guest, User | Read reviews and comments from other users |
| Manage Reviews | User (Owner) | Edit or delete own reviews |
| Reply to Reviews | Consultant, Admin | Post professional responses to customer reviews |
| Manage Products | Admin | Create, edit, delete products and update product information |

### 2. DR. C AI CHATBOT MODULE
| Use Case | Actor | Description |
|----------|-------|-------------|
| Chat with Dr. C | Guest, User | Send messages to AI skincare advisor and receive personalized responses (Rate Limited: 20/hour) |
| Get Recommendations | Guest, User | Receive product recommendations based on skin concerns detected from chat |
| View Chat History | User | Access previous conversation messages with Dr. C |
| View Sessions | User | View list of past chat sessions with date, concerns, and message count |
| Generate Report | User | End a session and receive a consultation report |
| Delete Messages | Admin | Remove inappropriate or spam messages from Dr. C conversations |
| Manage Sessions | Admin | View and delete all user Dr. C sessions across the system |

### 3. APPOINTMENTS MODULE
| Use Case | Actor | Description |
|----------|-------|-------------|
| Create Appointment | Guest, User | Book a consultation appointment with available date/time and details |
| View My Appointments | User | See list of personal appointments with status and details |
| Update Appointment | User (Creator), Consultant, Admin | Change appointment status (pending, confirmed, completed, cancelled) |
| Delete Appointment | User (Creator), Admin | Cancel and remove appointment from system |
| Receive Notifications | User | Get email notifications for appointment confirmations and status changes |
| Manage Appointments | Consultant, Admin | View all appointments, assign to consultants, manage schedules |
| Submit Consultation Report | Consultant | Document findings and recommendations after consultation |
| Approve Report | Admin | Review and approve consultant's reports before sending to user |
| View Analytics | Consultant, Admin | See appointment statistics, completion rates, and trends |
| Export Reports | Consultant, Admin | Download appointment and consultation data in multiple formats |

### 4. AUTHENTICATION MODULE
| Use Case | Actor | Description |
|----------|-------|-------------|
| Register Account | Guest | Create new account with email and password (with email verification) |
| Login | Guest | Access account using email and password credentials |
| OAuth Login | Guest | Sign in using Google account (OAuth 2.0) |
| Verify Email | Unverified User | Confirm email address to activate full account access |
| Reset Password | User | Recover account access by resetting forgotten password |
| Logout | User | Securely sign out from account |

### 5. PROFILE MODULE
| Use Case | Actor | Description |
|----------|-------|-------------|
| View Profile | User | Display personal profile information and settings |
| Edit Profile | User | Update name, phone, location, and other personal details |
| Update Password | User | Change account password for security |
| Update Email | User | Change registered email address with verification |
| Delete Account | User | Permanently remove account and associated data |
| View Public Profile | Guest, User | View another user's public profile information |

### 6. ADMIN DASHBOARD MODULE
| Use Case | Actor | Description |
|----------|-------|-------------|
| Manage Settings | Admin | Configure site-wide settings and preferences |
| Configure Content | Admin | Update front page titles, descriptions, and system content |
| View Analytics | Admin | Monitor system usage, user activity, and key metrics |
| Manage Users | Admin | View, edit, or deactivate user accounts and roles |
| View Activity Log | Admin | Track all system activities and user actions for auditing |

## Actor Relationships

```
┌─────────────┐
│   Guest     │ (Not authenticated, read-only access to most features)
│   (Public)  │
└──────┬──────┘
       │ Register/Login/OAuth
       ▼
┌──────────────────────┐
│ Authenticated User   │ (Full access to personal features)
│ (Customer)           │ Can: Browse, Review, Chat, Appointments, Profile
└──────┬───────────────┘
       │ Admin Promotion
       ▼
┌──────────────────────┐     ┌──────────────────┐
│ Admin                │◄────┤ Consultant       │
│ (Full System Access) │     │ (Appointment &   │
│                      │     │  Report Manager) │
└──────────────────────┘     └──────────────────┘
```

## System Boundary & External Systems

```
┌────────────────────────────────────────────────────────────┐
│                   CeraVe System                            │
│  (All use cases listed above)                             │
└────────────────────────────────────────────────────────────┘
           ▲                        ▲
           │                        │
           │                        │
    ┌──────┴────────┐      ┌────────┴──────────┐
    │  Google OAuth │      │ Gemini AI API    │
    │  (OAuth 2.0)  │      │ (For Dr. C)      │
    └───────────────┘      └──────────────────┘
    
    ┌──────────────────┐    ┌──────────────────┐
    │  Email Service   │    │  File Storage    │
    │  (SMTP)          │    │  (Images/Videos) │
    └──────────────────┘    └──────────────────┘
```

## Key Features Summary

- **6 Main Modules**: Products, Dr. C AI, Appointments, Auth, Profile, Admin
- **3 User Roles**: Guest, Authenticated User, Admin/Consultant
- **16 Primary Use Cases** across all modules
- **Rate Limiting**: Dr. C chat (20 messages/hour per user/IP)
- **Notifications**: Email notifications for appointments
- **External Integrations**: Google OAuth, Gemini AI API, Email, File Storage
- **Security**: Email verification, password reset, OAuth tokens, CSRF protection
- **Admin Features**: User management, settings, analytics, activity logging

## Data Flow Highlights

1. **Products Flow**: Browse → View Details → Review → Recommend (via Dr. C)
2. **Dr. C Flow**: Chat → Detect Concerns → Recommend Products → Generate Report
3. **Appointments Flow**: Create → Confirm → Consult → Report → Approve
4. **Authentication Flow**: Register → Verify Email → Login → Use Features → Logout
5. **Profile Flow**: Create → View/Edit → Update Personal Info → Delete if needed
