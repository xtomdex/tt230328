
# Test assignment




## Requirements

- Docker (with docker-compose)
- make


## Deployment

To deploy this project turn on Docker on your machine and run

```bash
  make init
```


## API Reference

#### Host
```http
  http://localhost:8888
```

#### Swagger Documentation

```http
  GET /docs
```

#### Homepage

```http
  GET /
```

#### Get all users with filter

```http
  GET /users
```
All parameters are **optional**.

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `page` | `integer` | Page number. Default - 1.|
| `limit` | `integer` | Items count per page. Default - 25.|
| `is_active` | `integer` | Filter active/inactive users (0 or 1).|
| `is_member` | `integer` | Filter member/non-member users (0 or 1).|
| `user_type` | `array` | Filter users by their types. Multiple values available (1;2;3).|
| `last_login_from` | `date(YYYY-MM-DD)` | Filter users last logined after provided date.|
| `last_login_to` | `date(YYYY-MM-DD)` | Filter users last logined before provided date.|

