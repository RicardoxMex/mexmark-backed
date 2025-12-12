# Authentication API Documentation

Este documento describe los endpoints de autenticación implementados usando Action Controllers.

## Endpoints Disponibles

### 1. Registro de Usuario
**POST** `/api/auth/register`

```json
{
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Nota:** También acepta `confirmed_password` como alternativa a `password_confirmation`.

**Respuesta exitosa (201):**
```json
{
    "message": "Registration successful",
    "user": {
        "id": 1,
        "name": "Juan Pérez",
        "email": "juan@example.com",
        "email_verified_at": null,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    },
    "token": "1|abcdef123456...",
    "token_type": "Bearer"
}
```

### 2. Inicio de Sesión
**POST** `/api/auth/login`

```json
{
    "email": "juan@example.com",
    "password": "password123",
    "remember": true
}
```

**Respuesta exitosa (200):**
```json
{
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "Juan Pérez",
        "email": "juan@example.com",
        "email_verified_at": null,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    },
    "token": "1|abcdef123456...",
    "token_type": "Bearer"
}
```

### 3. Cerrar Sesión
**POST** `/api/auth/logout`

Requiere autenticación (Bearer token). Revoca solo el token actual.

**Headers:**
```
Authorization: Bearer 1|abcdef123456...
```

**Respuesta exitosa (200):**
```json
{
    "message": "Logout successful"
}
```

### 3.1. Cerrar Todas las Sesiones
**POST** `/api/auth/logout-all`

Requiere autenticación (Bearer token). Revoca todos los tokens del usuario.

**Headers:**
```
Authorization: Bearer 1|abcdef123456...
```

**Respuesta exitosa (200):**
```json
{
    "message": "All sessions logged out successfully"
}
```

### 4. Recuperar Contraseña
**POST** `/api/auth/forgot-password`

```json
{
    "email": "juan@example.com"
}
```

**Respuesta exitosa (200):**
```json
{
    "message": "Password reset link sent to your email."
}
```

### 5. Restablecer Contraseña
**POST** `/api/auth/reset-password`

```json
{
    "token": "reset_token_here",
    "email": "juan@example.com",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Respuesta exitosa (200):**
```json
{
    "message": "Password has been reset successfully."
}
```

### 6. Verificar Email
**GET** `/api/auth/verify-email/{id}/{hash}`

Este endpoint se accede mediante el enlace enviado por email.

**Respuesta exitosa (200):**
```json
{
    "message": "Email verified successfully."
}
```

### 7. Reenviar Verificación de Email
**POST** `/api/auth/email/verification-notification`

Requiere autenticación.

**Respuesta exitosa (200):**
```json
{
    "message": "Verification link sent to your email."
}
```

### 8. Ver Perfil
**GET** `/api/auth/profile`

Requiere autenticación.

**Respuesta exitosa (200):**
```json
{
    "user": {
        "id": 1,
        "name": "Juan Pérez",
        "email": "juan@example.com",
        "email_verified_at": null,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### 9. Actualizar Perfil
**PUT** `/api/auth/profile`

Requiere autenticación.

```json
{
    "name": "Juan Carlos Pérez",
    "email": "juancarlos@example.com",
    "current_password": "oldpassword123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Respuesta exitosa (200):**
```json
{
    "message": "Profile updated successfully.",
    "user": {
        "id": 1,
        "name": "Juan Carlos Pérez",
        "email": "juancarlos@example.com",
        "email_verified_at": null,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### 10. Eliminar Cuenta
**DELETE** `/api/auth/profile`

Requiere autenticación.

```json
{
    "password": "password123"
}
```

**Respuesta exitosa (200):**
```json
{
    "message": "Account deleted successfully."
}
```

## Middleware Disponible

### EnsureEmailIsVerified
Para rutas que requieren email verificado:

```php
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Rutas que requieren email verificado
});
```

## Controladores Implementados

- `LoginController` - Maneja el inicio de sesión
- `RegisterController` - Maneja el registro de usuarios
- `LogoutController` - Maneja el cierre de sesión
- `ForgotPasswordController` - Maneja solicitudes de recuperación de contraseña
- `ResetPasswordController` - Maneja el restablecimiento de contraseña
- `VerifyEmailController` - Maneja la verificación de email
- `ResendVerificationController` - Reenvía enlaces de verificación
- `ProfileController` - Maneja operaciones del perfil de usuario

## Form Requests

- `LoginRequest` - Validación para inicio de sesión
- `RegisterRequest` - Validación para registro

## Configuración Adicional

Asegúrate de configurar:

1. **Mail**: Para envío de emails de verificación y recuperación
2. **Sanctum**: Para autenticación API (si usas tokens)
3. **Session**: Para autenticación basada en sesiones

## Autenticación con Tokens

Todas las rutas protegidas requieren el header `Authorization` con el token Bearer:

```
Authorization: Bearer 1|abcdef123456...
```

## Ejemplo de Uso con JavaScript

```javascript
// Variable para almacenar el token
let authToken = localStorage.getItem('auth_token');

// Registro
const register = async (userData) => {
    const response = await fetch('/api/auth/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(userData)
    });
    
    const data = await response.json();
    
    if (data.token) {
        authToken = data.token;
        localStorage.setItem('auth_token', authToken);
    }
    
    return data;
};

// Login
const login = async (credentials) => {
    const response = await fetch('/api/auth/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(credentials)
    });
    
    const data = await response.json();
    
    if (data.token) {
        authToken = data.token;
        localStorage.setItem('auth_token', authToken);
    }
    
    return data;
};

// Logout
const logout = async () => {
    const response = await fetch('/api/auth/logout', {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${authToken}`,
            'Accept': 'application/json'
        }
    });
    
    const data = await response.json();
    
    // Limpiar token local
    authToken = null;
    localStorage.removeItem('auth_token');
    
    return data;
};

// Función helper para hacer requests autenticados
const authenticatedFetch = async (url, options = {}) => {
    const defaultHeaders = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${authToken}`
    };
    
    return fetch(url, {
        ...options,
        headers: {
            ...defaultHeaders,
            ...options.headers
        }
    });
};

// Ejemplo de uso para obtener perfil
const getProfile = async () => {
    const response = await authenticatedFetch('/api/auth/profile');
    return response.json();
};
```

## Configuración de Sanctum

Asegúrate de que Sanctum esté correctamente configurado:

1. **Publicar migración de tokens:**
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

2. **Agregar middleware en `app/Http/Kernel.php`:**
```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```

3. **Configurar CORS si es necesario en `config/cors.php`**