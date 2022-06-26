# Controllers

* 🔖 **Generate**
* 🔖 **Routing**

___

## 📑 Generate

Vous povuez générer un controller vierge, à partir d'un modèle et de type ressource.

```bash
php artisan make:controller TaskController
```

[Controllers](https://laravel.com/docs/9.x/controllers#writing-controllers)

___

## 📑 Routing

Dans le fichier de route web vous pouvez associér une requeest à une action.

```php
Route::get('/task', [TaskController::class, 'index']);
```

```php
public function index(): View
{
    return view('task.index');
}
```

### 🏷️ **Paramètre**

Vous pouvez déclarer un slug dans la âth qui sera passée à l'action du controller

```php
Route::get('/task/{id}/delete', [TaskController::class, 'delete']);
```

```php
public function delete(int $id): View
```

Des contraintes peuvent être appliquées

```php
Route::get('/task/{id}/delete', [TaskController::class, 'delete'])
    ->where(['id' => '\d+']);
```

### 🏷️ **Méthode**

Pour accepter plusieurs méthodes http il faut utiliser la méthode match

```php
Route::match(['get', 'post'], '/task/create', [TaskController::class, 'create']);
```

Attention les méthodes autre que GET veulent vérifier le jeton de l'utilisateur, s'il n'est pas présent un code 419 sera envoyé au client. Vous pouvez générer un jeton avec le helper crsf.

```html
<h1>Edit task</h1>

<form action="" method="post">
    @csrf
    <button>Envoyer</button>
</form>
```

### 🏷️ **Closure**

Il est possible d'injecter soit même des arguments au controller en utilisant une closure.

```php
Route::get('/task/{id}', function ($id) {
    return app()
        ->make(TaskController::class)
        ->callAction('show', [
            'id' => $id
        ]);
})->where(['id' => '\d+']);
```

### 🏷️ **Group**

VOus poiuvez regrouper l'ensemble des déclarations pour un controller

```php
Route::controller(TaskController::class)->group(function () {
    Route::get('/task', 'index');
    Route::match(['get', 'post'], '/task/create', 'create');
    Route::match(['get', 'post'], '/task/{id}/edit', 'edit')->where(['id' => '\d+']);
    Route::get('/task/{id}/delete', 'delete')->where(['id' => '\d+']);
    Route::get('/task/{id}',  'show')->where(['id' => '\d+']);
});
```

Après avoir determiné l'accès aux données nous voudrond nous intérésser à l'injection de dependance et après avoir terminé un CRUD en web nous nous interesserons à l'utilisation d'un controller de type ressource pour une api.

### 🏷️ **Name**

Les routes nommées permettent la génération pratique d'URL ou de redirections pour des routes spécifiques. Vous pouvez spécifier un nom pour une route en enchaînant la méthode name sur la définition de route.

```php
Route::get(
    '/user/profile',
    [UserProfileController::class, 'show']
)->name('profile');
```

Le nommage permet une redirection sans connaitre l'url.

```php
$url = route('profile');
return redirect()->route('profile');
```
