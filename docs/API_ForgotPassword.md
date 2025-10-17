# API Documentation

## POST /api/forgot-password

### Headers
```
Content-Type: application/json
```

### Request Body
```json
{
  "username": "string",
  "newpassword": "string"
}
```

### Response

#### Success (200)
```json
{
  "message": "เปลี่ยนรหัสผ่านสำเร็จ"
}
```

#### Error (400)
```json
{
  "message": "Bad request - No data provided"
}
```

#### Error (400)
```json
{
  "message": "Username and new password are required"
}
```

#### Error (404)
```json
{
  "message": "Username not found"
}
```

#### Error (500)
```json
{
  "message": "Server error"
}
```
