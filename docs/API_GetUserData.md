# API Documentation

## GET /api/get-user-data

### Headers
```
Content-Type: application/json
```

### Request Body
```json
{
  "token": "string"
}
```

### Response

#### Success (200)
```json
{
  "message": [
    {
      "id": 1,
      "user_id": 1,
      "detail_field": "value"
    }
  ]
}
```

#### Error (400)
```json
{
  "message": "Bad request - No data provided"
}
```

#### Error (401)
```json
{
  "message": "Invalid token"
}
```

#### Error (401)
```json
{
  "valid": false,
  "error": "Invalid token"
}
```
