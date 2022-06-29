# Security

* 🔖 **Starter**
* 🔖 **Manuel**
* 🔖 **Guards**

___

## 📑 Starter

Vous pouvez utilsier un starter d'authentification à la création du projet, une fois un projet en palce il faudra faire attention à l'ecrasement des fichiers.

[Starter Kit](https://laravel.com/docs/9.x/starter-kits)

En dehors des starter kit il n'y a pas de comandes pour générer un registration form ou login form malgrès la présence d'un composant auth.

___

## 📑 Manuel

Observons une authautification manuelle.

[Authenticating users](https://laravel.com/docs/9.x/authentication#authenticating-users)

### 🏷️ **Register**

La création de compte est classique, nous utiliserons des validations faibles pour l'exemple.

Ajoutons deux routes pour le formulaire et l'insertion.

```php
Route::controller(SecurityController::class)->group(function () {
    Route::get('/register', 'register')->name('security.register');
    Route::post('/register', 'store')->name('security.store');
});
```

*register*

```php
public function register(): View
{
    return view('security.register', [
        'user' => new User()
    ]);
}
```

Pour la sauvegarde il faut penser à hasher le mot de passe!

*store*

```php
public function store(SecurityRegisterRequest $request)
{
    $validated = $request->validated();
    $user = new User($validated);
    $user->password = bcrypt($user->password);
    $user->save();
    return redirect()->route('task.index');
}
```

Une vue avec bulma ou autre est necessaire.

*resources/views/security/register.blade.php*

```html
@extends('layouts.app')

@section('title', 'Register')

@section('content')

    <section class="hero is-fullheight-with-navbar is-dark">
        <div class="hero-body">
            <div class="column is-full">
                <p class="title mb-6">
                    Create account
                </p>
                <p class="subtitle columns">
                    {{ Form::model($user, [
                        'route' => 'security.store',
                        'class' => 'column is-two-thirds',
                    ]) }}
                <div class="field">
                    {{ Form::label('name', 'Name', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('name')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::text('name', null, [
                            'class' => 'input',
                            'placeholder' => 'User Name'
                        ]) }}
                    </div>
                </div>
                <div class="field">
                    {{ Form::label('email', 'Email', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('email')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::email('email', null, [
                            'class' => 'input',
                            'placeholder' => 'Email'
                        ]) }}
                    </div>
                </div>
                <div class="field">
                    {{ Form::label('password', 'Password', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('password')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::password('password', [
                            'class' => 'input',
                            'placeholder' => 'Password'
                        ]) }}
                    </div>
                </div>
                <div class="field">
                    {{ Form::label('password', 'Confirmation', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('password_confirmation')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::password('password_confirmation', [
                            'class' => 'input',
                            'placeholder' => 'Password'
                        ]) }}
                    </div>
                </div>
                <div class="field mt-4">
                    <div class="control">
                        {{ Form::submit('Create Account', [
                            'class' => 'button is-link',
                        ]) }}
                    </div>
                </div>
            </div>
            {{ Form::close() }}
            </p>
        </div>
        </div>
    </section>
@endsection
```

### 🏷️ **Login**

Ajoutons deux routes pour le formulaire et le login.

```php
Route::get('/login', 'login')->name('security.login');
Route::post('/login', 'authenticate')->name('security.authenticate');
```

*login*

```php
public function login(): View
{
    return view('security.login', [
        'user' => new User()
    ]);
}
```

Pour le login, il faut un renouvellmeent de session pour éviter les attaques par fixation!

*authenticate*

```php
public function authenticate(SecurityLoginRequest $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('task');
    }
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}
```

Une vue avec bulma ou autre est necessaire.

*resources/views/security/login.blade.php*

```html
@extends('layouts.app')

@section('title', 'Register')

@section('content')

    <section class="hero is-fullheight-with-navbar is-dark">
        <div class="hero-body">
            <div class="column is-full">
                <p class="title mb-6">
                    Authenticate
                </p>
                <p class="subtitle columns">
                    {{ Form::model($user, [
                        'route' => 'security.authenticate',
                        'class' => 'column is-two-thirds',
                    ]) }}
                <div class="field">
                    {{ Form::label('email', 'Email', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('email')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::email('email', null, [
                            'class' => 'input',
                            'placeholder' => 'Email'
                        ]) }}
                    </div>
                </div>
                <div class="field">
                    {{ Form::label('password', 'Password', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('password')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::password('password', [
                            'class' => 'input',
                            'placeholder' => 'Password'
                        ]) }}
                    </div>
                </div>
                <div class="field mt-4">
                    <div class="control">
                        {{ Form::submit('Login', [
                            'class' => 'button is-link',
                        ]) }}
                    </div>
                </div>
            </div>
            {{ Form::close() }}
            </p>
        </div>
        </div>
    </section>
@endsection
```

### 🏷️ **Logout**

Il faut ajouter une route.

```php
Route::get('/logout', 'logout')->name('security.logout')->middleware('auth');
```

Dans l'action du controller, la session est detruite.

```php
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
}
```

___

## 📑 Guard

Maintenant que nous pouvons créer un compte et nous authentifier, observons comment vérifier l'état de l'utilisateur.


### 🏷️ **Views**

Dans les vues vous pouvez utiliser la directive @auth.

```php
@auth
// The user is authenticated...
@endauth
```

Auth prend en argument la guard à utiliser.

[Authentication](https://laravel.com/docs/9.x/blade#authentication-directives)

La directive inverse est @guest

```php
@guest
// The user is not authenticated...
@endguest
```

### 🏷️ **PHP**

Nous pouvons facilement protéger nos routes en utilisant le middleware auth.

```php
Route::get('/task', 'index')->name('task.index')->middleware('auth');
```

Attention à modifier le nom de la route login dans le fichier Authenticate.php

```php
protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        return route('security.login');
    }
}
```
### 🏷️ **Middleware**

Pour l'implementation d'un RBAC, d'un ACL ou autre mécanisme plus avancé il faudra installer des packages additionnels et créer des middleware pour effectuer des vérifications personnalisées.

[Custom Guards](https://dev.to/slyfirefox/laravel-authentication-understanding-guards-and-implementing-authenticatables-2364)