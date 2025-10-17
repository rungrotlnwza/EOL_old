# API Documentation

## POST /api/register

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

#### Success (201)
```json
{
  "message": "สมัครสมาชิกสำเร็จ"
}
```

#### Error (400)
```json
{
  "message": "ขออภัย username ถูกใช้งานไปแล้ว"
}
```

#### Error (400)
```json
{
  "message": "Bad request - Username and password are required"
}
```

#### Error (500)
```json
{
  "message": "เกิดข้อผิดพลาดในระบบ"
}
```
