# VaccTrack API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication

### Register New Parent
**Endpoint:** `POST /api/parents/register`

**Description:** Register a new parent/guardian account in the system.

**Request Body:**
```json
{
    "first_name": "Maria",
    "last_name": "Cruz",
    "email": "maria@example.com",
    "password": "securePassword123",
    "password_confirmation": "securePassword123",
    "phone": "+639171234567",
    "address": "123 Health Street, Manila"
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "Parent registered successfully",
    "data": {
        "parent_id": 1,
        "name": "Maria Cruz",
        "email": "maria@example.com"
    }
}
```

---

### Login
**Endpoint:** `POST /api/auth/login`

**Description:** Authenticate parent and receive access token.

**Request Body:**
```json
{
    "email": "maria@example.com",
    "password": "securePassword123"
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Authentication successful",
    "data": {
        "parent_id": 1,
        "name": "Maria Cruz",
        "email": "maria@example.com",
        "token": "token_hash_here"
    }
}
```

---

## Public Endpoints

### Get Clinic Information
**Endpoint:** `GET /api/clinic-info`

**Description:** Get public clinic information without authentication.

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Clinic information retrieved successfully",
    "data": {
        "clinic_name": "VaccTrack Clinic",
        "phone": "(02) 123-4567",
        "email": "clinic@vacctrack.ph",
        "address": "123 Health Street",
        "city": "Manila",
        "province": "Metro Manila",
        "timezone": "Asia/Manila",
        "operating_hours": {
            "Monday": {
                "is_open": true,
                "open_time": "08:00",
                "close_time": "17:00"
            },
            "Tuesday": {
                "is_open": true,
                "open_time": "08:00",
                "close_time": "17:00"
            },
            "...": "..."
        },
        "consultation_fee": 500,
        "vaccine_service_fee": 200
    }
}
```

---

## Parent Endpoints

### Get Parent's Children
**Endpoint:** `GET /api/parents/{parent_id}/children`

**Description:** Get list of children registered under a parent account.

**Path Parameters:**
- `parent_id` (required): The parent's ID

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Children retrieved successfully",
    "data": [
        {
            "id": 1,
            "first_name": "Juan",
            "last_name": "Cruz",
            "dob": "2020-05-15",
            "gender": "Male",
            "vaccine_records_count": 5
        },
        {
            "id": 2,
            "first_name": "Anna",
            "last_name": "Cruz",
            "dob": "2022-03-20",
            "gender": "Female",
            "vaccine_records_count": 3
        }
    ]
}
```

---

### Get Parent's Appointments
**Endpoint:** `GET /api/parents/{parent_id}/appointments`

**Description:** Get all appointments for parent's children.

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Appointments retrieved successfully",
    "data": [
        {
            "id": 1,
            "child_name": "Juan Cruz",
            "vaccine": "BCG (Tuberculosis)",
            "appointment_date": "2026-03-20",
            "appointment_time": "10:00",
            "status": "Scheduled"
        },
        {
            "id": 2,
            "child_name": "Anna Cruz",
            "vaccine": "Polio",
            "appointment_date": "2026-03-22",
            "appointment_time": "14:00",
            "status": "Scheduled"
        }
    ]
}
```

---

## Child Endpoints

### Get Child's Vaccine Records
**Endpoint:** `GET /api/children/{child_id}/records`

**Description:** Get all vaccine records for a specific child.

**Path Parameters:**
- `child_id` (required): The child's ID

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Vaccine records retrieved successfully",
    "data": {
        "child": {
            "id": 1,
            "name": "Juan Cruz"
        },
        "records": [
            {
                "id": 1,
                "vaccine_name": "BCG (Tuberculosis)",
                "date_given": "2020-06-10",
                "dose_number": 1,
                "notes": "Given at birth"
            },
            {
                "id": 2,
                "vaccine_name": "Polio",
                "date_given": "2020-07-15",
                "dose_number": 1,
                "notes": "First dose administered"
            }
        ]
    }
}
```

---

## Appointment Endpoints

### Create Appointment
**Endpoint:** `POST /api/appointments`

**Description:** Create a new vaccination appointment for a child.

**Request Body:**
```json
{
    "child_id": 1,
    "vaccine_id": 2,
    "appointment_date": "2026-04-15",
    "appointment_time": "10:30",
    "notes": "Follow-up dose"
}
```

**Response (201 Created):**
```json
{
    "success": true,
    "message": "Appointment created successfully",
    "data": {
        "appointment_id": 3,
        "appointment_date": "2026-04-15",
        "appointment_time": "10:30"
    }
}
```

---

### Update Appointment
**Endpoint:** `PUT /api/appointments/{appointment_id}`

**Description:** Update an existing appointment (reschedule or change status).

**Path Parameters:**
- `appointment_id` (required): The appointment's ID

**Request Body:**
```json
{
    "appointment_date": "2026-04-20",
    "appointment_time": "14:00",
    "status": "Scheduled",
    "notes": "Rescheduled by parent"
}
```

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Appointment updated successfully",
    "data": {
        "id": 3,
        "child_id": 1,
        "vaccine_id": 2,
        "appointment_date": "2026-04-20",
        "appointment_time": "14:00",
        "status": "Scheduled",
        "notes": "Rescheduled by parent"
    }
}
```

---

### Cancel Appointment
**Endpoint:** `DELETE /api/appointments/{appointment_id}`

**Description:** Cancel a vaccination appointment.

**Path Parameters:**
- `appointment_id` (required): The appointment's ID

**Response (200 OK):**
```json
{
    "success": true,
    "message": "Appointment cancelled successfully"
}
```

---

## Error Responses

### 400 Bad Request
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

### 404 Not Found
```json
{
    "success": false,
    "message": "Child not found"
}
```

### 422 Unprocessable Entity
```json
{
    "success": false,
    "message": "Failed to create appointment",
    "error": "The appointment date must be a date after today."
}
```

---

## Rate Limiting

API requests are rate-limited to **60 requests per minute** to prevent abuse.

---

## Testing the API

### Using cURL

```bash
# Register a new parent
curl -X POST http://localhost:8000/api/parents/register \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Maria",
    "last_name": "Dela Cruz",
    "email": "maria@example.com",
    "password": "Test@12345",
    "password_confirmation": "Test@12345",
    "phone": "+639171234567"
  }'

# Get clinic info
curl http://localhost:8000/api/clinic-info

# Get parent's children
curl http://localhost:8000/api/parents/1/children

# Create appointment
curl -X POST http://localhost:8000/api/appointments \
  -H "Content-Type: application/json" \
  -d '{
    "child_id": 1,
    "vaccine_id": 2,
    "appointment_date": "2026-04-15",
    "appointment_time": "10:30"
  }'
```

### Using Postman

1. Import the API endpoints into Postman
2. Set environment variables:
   - `base_url` = `http://localhost:8000`
   - `parent_id` = Your parent ID
   - `child_id` = Your child ID
3. Test each endpoint

---

## Security Notes

- **HTTPS Required:** Always use HTTPS in production
- **API Token:** Store tokens securely client-side (not in localStorage for sensitive apps)
- **CORS:** Configure CORS headers for third-party integrations
- **Rate Limiting:** Implement rate limiting to prevent abuse
- **Input Validation:** All inputs are validated server-side
- **Password:** Passwords are hashed using bcrypt algorithm

---

## Future Enhancements

- [ ] JWT/Sanctum token-based authentication
- [ ] Pagination for list endpoints
- [ ] Filtering and sorting
- [ ] Webhook notifications
- [ ] Batch operations
- [ ] Export functionality (PDF, CSV)
- [ ] Advanced search
- [ ] GraphQL alternative

---

**Last Updated:** March 12, 2026
