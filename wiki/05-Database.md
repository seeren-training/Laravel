# Database

* 🔖 **Configuration**
* 🔖 **Models**
* 🔖 **Migration**
* 🔖 **Fixtures**
* 🔖 **Opérations**

___

## 📑 Configuration

Renseignez vos identifiants de conenction dans le fichier `.env`.
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_app
DB_USERNAME=root
DB_PASSWORD=
```

Vous n'avez pas de commande pour créer la database et devez le faire vous même.

Par défaut Laravel a déjà créé des tables pas encore migérs, pour les migrer utilisez la commande de migration.

```bash
php artisan migrate
```

Il est possible de créer une commande pour cette routine. L'utilitaire permet d'annuler, de reset ou de merge les migrations.

[Migration](https://laravel.com/docs/9.x/migrations#running-migrations)

___

## 📑 Models

L'ORM utilisé par  Laravel est `Eloquent`. Vous pouvez générer des models qui sont vos tables.

```bash
php artisan make:model Task
```

Vous devriez générer une migration pour spécifier les caractéristiques de la table à migrer.

```bash
php artisan make:model Task --migration
```

Il est possible de créer une migration quand un model existe déjà.

```bash
php artisan make:migration Task
```

[Generating models](https://laravel.com/docs/9.x/eloquent#generating-model-classes)

### 🏷️ **Types**

Vous pouvez spécifier vos colonnes en leur associant un type dans le fichier de migration.

```php
public function up()
{
    Schema::create('states', function (Blueprint $table) {
        $table->id();
        $table->enum('value', [
            'TODO',
            'DOING',
            'DONE',
        ]);
        $table->timestamps();
    });
}
```

De nombreux types sont disponibles CF documentation

[Adding column](https://laravel.com/docs/5.0/schema#adding-columns)

### 🏷️ **Tailles**

La taille se spécifie en argument 2 des signatures.

```php
$table->char('name', 4);
```

### 🏷️ **Contraintes**

Les contraintes se spécifient de la même façon.

```php
$table->primary('id');
$table->index('state');
```

[Adding keys](https://laravel.com/docs/5.0/schema#adding-indexes)

### 🏷️ **Relation**

Attention, la migration s'effectuera dans l'ordre de création des fichiers, vous devez donc penser au modèle physique de données avant de créer vos migrations.

Deuxième piège, en ajoutant une foreign key, la colonne doit exister et avoir les mêmes type, taille et attribut que la référence.

```php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('description');
    $table->bigInteger('states_id')->unsigned();
    $table->foreign('states_id')
        ->references('id')
        ->on('states');
    $table->timestamps();
});
```

___

## 📑 Migration


Une fois vos fichiers de migration créés et vos tables définies, vous pouvez exécuter les migration.

```bash
php artisan migrate
```

[Running migrations](https://laravel.com/docs/7.x/migrations#running-migrations)

___

## 📑 Fixtures

Il nous faudra certainement remplir des tables pour avoir des valeurs par défaut. C'est le concept de Seeder qui le permet.

[Seeders](https://laravel.com/docs/9.x/seeding#running-seeders)

```php
php artisan make:seeder StateSeeder  
```

Le fichier créé possède la responsabilité d'effectuer des enregistrements. Il est conseillé de le relier au point d'entré des seeder.

*database/seeders/DatabaseSeeder.php*

```php
public function run()
{
    $this->call([
        StateSeeder::class,
    ]);
}
```

Enfin vous pouvez effectuer des insertions, nous utiliserons un type enum plus tard.

```php
public function up()
{
    Schema::create('states', function (Blueprint $table) {
        $table->id();
        $table->enum('value', [
            'TODO',
            'DOING',
            'DONE',
        ]);
        $table->timestamps();
    });
}
```

Pour exécuter les seeders la commande est la suivante.

```bash
php artisan db:seed
```
___

## 📑 Opérations

Nous allons succintement nous interesser à la syntaxe du CRUD.

### 🏷️ **Insertion**

La syntaxe est celle observée précédement.

```php
DB::table('users')->insert([
    'email' => 'kayla@example.com',
    'votes' => 0
]);
```

Il est également possible d'utiliser la classe du modèle pour ne pas passer par un manager, le type renvoyé sera celui du modèle.

```php
User::insert([
    'email' => 'kayla@example.com',
    'votes' => 0
]);
```

Pour effectuer une insertion en relation sans cascade il faut imbriquer les opérations.

```php
Task::insert([
    'name' => 'Randommm',
    'description' => 'Randommm description',
    'state_id' => DB::table('state')->get()->where('value', 'TODO')->first()->id,
    'created_at' => new DateTime(),
    'updated_at' => new DateTime(),
]);
```

[Persisting](https://laravel.com/docs/9.x/queries#insert-statements)

### 🏷️ **Lecture**

C'est le pattern Active record qui est utilisé.

```php
$users = DB::table('users')->get();
 
foreach ($users as $user) {
    echo $user->name;
}
```

Pour une lecture unitaire vous devez utiliser les clauses du query builder.

```php
$user = DB::table('users')->where('name', 'John')->first();
```

Pour lire avec des relations plusieurs syntaxes.

```php
$state = State::find(1);
$tasks = $state->tasks;
```

La seconde syntaxe ne permet d'extraire les valeurs liées lors d'une inversion.

```php
Task::with('state:id,value')->get()
```

[Query](https://laravel.com/docs/9.x/queries#running-database-queries)

### 🏷️ **Suppression**

Pas de manager pour les modifications de données.

```php
$deleted = DB::table('users')->where('votes', '>', 100)->delete();
```

[Delete](https://laravel.com/docs/9.x/queries#delete-statements)

### 🏷️ **Mise à jour**

Le principe reste le même.

```php
$affected = DB::table('users')
              ->where('id', 1)
              ->update(['votes' => 1]);
```