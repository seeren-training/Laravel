# Forms

* 🔖 **Affichage**
* 🔖 **Validation**

___

## 📑 Affichage

Première étape est la construction du formulaire.

Il est consillé d'utiliser un package additionnel qui n'est plus présent par défaut.

```bash
composer require laravelcollective/html
```

Il faut l'ajouter au providers du projet.

*config.app.php*

```php
/*
  * Package Service Providers...
  */
Collective\Html\HtmlServiceProvider::class
```

[Collective HTML](https://laravelcollective.com/docs/6.x/html)

### 🏷️ **Déclaration**

Vous pouvez ouvrir un formulaire ou construier un formulaire à partir d'un modèle.

```php
{{ Form::model($task, [
    'route' => 'task.create',
    'class' => 'column is-two-thirds',
]) }}
```

Le CSRF est généré automatiquement. Si le form est ouvert il doit être refermé.

```php
{{ Form::close() }}
```

[Opening](https://laravelcollective.com/docs/6.x/html#opening-a-form)

### 🏷️ **Widgets**

La package offre une collection d'helper pour générer la syntaxe HTML, exemple avec Bulma.

```php
<div class="field">
    {{ Form::label('name', 'Name', [
        'class' => 'label has-text-white',
    ]) }}
    <div class="control">
        {{ Form::text('name', null, [
            'class' => 'input',
            'placeholder' => 'Task Name',
        ]) }}
    </div>
</div>
```

[Fields](https://laravelcollective.com/docs/6.x/html#text)

___

## 📑 Validation

Pour valider un formulaire vous allez créer un middleware qui intercepte la request, la valide et redirige sur le referer si la request comporte des erreurs. Vous devez quand même passer par une action du controller qui fait finalement office d'API, la page qui traite n'est pas celle qui affiche le formulaire.

### 🏷️ **Routing**

Créons une route et une action pour une actio de creation.

*routes/web.php*

```php
Route::post('/task', 'store')->name('task.store');
```

*app/Http/Controllers/TaskController.php*

```php
public function store() { }
```
[Quickstart](https://laravel.com/docs/9.x/validation#validation-quickstart)

### 🏷️ **Validator**

Vous pouvez extarnaliser la logique de validation dans une request de type validator.

```bash
php artisan make:request TaskPostRequest
```

[Form Request](https://laravel.com/docs/9.x/validation#creating-form-requests)

*app/Http/Requests/TaskPostRequest.php*

```php
class TaskPostRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:task|max:255',
            'description' => 'required|max:255',
        ];
    }
}
```

Les règles de validation sont nombreuses et docume,tées.

[Validation rules](https://laravel.com/docs/9.x/validation#available-validation-rules)

Vous pouvez maintenant autowire la request et récupérer la données valide. Il faut noter le comportement implicite de la méthode `validated` qui provoque un 302 si la request n'est pas valide.

```php
    public function store(TaskPostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // request is valid at this point

        $task = new Task($validated);
        $task->state()->associate(State::get()->where('value', 'TODO')->first());
        $task->save();
        return redirect()->route('task.show', [
            'id' => $task->id
        ]);
    }
```

### 🏷️ **Erreurs**

Vous pouvez capter les erreurs via des directives, des fonctions ou une variable globale.

```html
@error('name')
    <div class="notification is-danger">{{ $message }}</div>
@enderror
```

[Working with errors](https://laravel.com/docs/9.x/validation#working-with-error-messages)