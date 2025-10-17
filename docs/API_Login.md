# API Documentation

## POST /api/login

### Headers
```
Content-Type: application/json
```

### Request Body
```json
{
  "username": "string",
  "password": "string"
}
```

### Response

#### Success (200)
```json
{
  "message": "Login success",
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
}
```

**Token Expires**: 24 hours

#### Error (400)
```json
{
  "message": "Bad request - No data provided"
}
```

#### Error (400)
```json
{
  "message": "Username and password are required"
}
```

#### Error (401)
```json
{
  "message": "Invalid username or password"
}
```

#### Error (500)
```json
{
  "message": "Server error"
}
```
