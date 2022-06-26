# Template

* 🔖 **Syntaxe**
* 🔖 **Assets**

___

## 📑 Syntaxe

Nous allons observer la syntaxe de base des templates.

[Template syntaxe](https://laravel.com/docs/9.x/blade)

### 🏷️ **Template Inheritance**

Vous pouvez définir des calques héritables.

*resources/views/layouts/app.blade.php*

```html
<html>

<head>
    <title>Task App - @yield('title')</title>
</head>

<body>
@section('sidebar')
@show
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
```

@section determine du contenu surchargeable, alors que @yield affiche une sectio ndéfinie par l'enfant.

*example-app/resources/views/task/index.blade.php*

```php
@extends('layouts.app')

@section('title', 'Task List')

@section('sidebar')
@parent
    <ul>
        <li>
            <a>Task List</a>
        </li>
    </ul>
@endsection

@section('content')
<h1>Task List</h1>
@endsection
```

### 🏷️ **Inclusion**

L'inclusion prend an argument une vue.

```php
@include('shared.errors')
```

Le passage d'argument est possible.

```php
@include('view.name', ['status' => 'complete'])
```

L'inclusion peut être conditionelle.

```php
@includeWhen($boolean, 'view.name', ['status' => 'complete'])
```

L'inclusion peut être itérative.

```php
@each('view.name', $jobs, 'job')
```

### 🏷️ **Conditionnal**

Les structures conditionelles utilisent les opérateurs php.

```php
@if (count($records) === 1)
    I have one record!
@elseif (count($records) > 1)
    I have multiple records!
@else
    I don't have any records!
@endif
```

Il existe des directives pour tester le rôle ou la présence de sesctions.

### 🏷️ **Loop**

Les boucles utilisent une syntaxe qui repose sur celle de php

```php
@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
@endfor
 
@foreach ($users as $user)
    <p>This is user {{ $user->id }}</p>
@endforeach
 
@forelse ($users as $user)
    <li>{{ $user->name }}</li>
@empty
    <p>No users</p>
@endforelse
 
@while (true)
    <p>I'm looping forever.</p>
@endwhile
```

Il peut être interessant de travailler avec la variable loop dans cette structure.

### 🏷️ **Url**

Le helper url permet de générer des url à partir de routes nommées.

```php
echo url("/posts/{$post->id}");
```

Le helper action permet de générer une url pour une action.
```php
$url = action('HomeController@index');
```

[Urls](https://laravel.com/docs/5.6/urls)

### 🏷️ **Other**

Il est possible de reendre des formulaires, des composants personnalisés, de créer des directives. Nous étudierons cela après les providers.

___

## 📑 Assets

Laravel Mix, un package développé par le créateur de Laracasts, Jeffrey Way, fournit une API fluide pour définir les étapes de construction de webpack pour votre application Laravel à l'aide de plusieurs préprocesseurs CSS et JavaScript courants.

Dans le projet il y a d&éjà un package.json et une configuration, insallons les packages.


```bash
npm install
```

Nous pouvons observer les différents scripts présents.

```json
"dev": "npm run development",
"development": "mix",
"watch": "mix watch",
"watch-poll": "mix watch -- --watch-options-poll=1000",
"hot": "mix watch --hot",
"prod": "npm run production",
"production": "mix --production"
```

[Running](https://laravel.com/docs/9.x/mix#running-mix)

Pour rendre vos scripts et links et il faut les saisir dans votre base.

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="/css/app.css" rel="stylesheet">
<script src="/js/app.js"></script>
```

### 🏷️ **SCSS**

Pour le scss vous devez utiliser la méthode appropriée.

```js
.sass('resources/scss/app.scss', 'public/css');
```

Exemple de theming avec Bulma

```bash
npm i bulma
```

*resources/scss/app.scss*

```bash
$primary: #8A4D76;
@import "~bulma";
```

*resources/views/task/create.blade.php*

```bash
@extends('layouts.app')

@section('title', 'New Task')

@section('content')
<h1> New task</h1>
<form action="" method="post">
    @csrf
    <button class="button is-primary">Envoyer</button>
</form>
@endsection
```

### 🏷️ **JS**

La dernière syntaxe est disponible sans avoir à configurer babel, les loaders, les polyfills etc.


*example-app/resources/js/task.js*

```js
export class Task {

    #name;

    constructor(name) {
        this.#name = name;
    }

    get name() {
        return this.#name
    }

}
```
*example-app/resources/js/app.js*

```js
import './bootstrap';

import { Task } from './task';

const task = new Task('Learn models');

console.log(task.name);
```

Il y a des shortcut pour configurer vue.js et react.