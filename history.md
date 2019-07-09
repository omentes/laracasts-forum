## History

### Episode 1
```bash
php artisan make:model Thread -mr
php artisan migrate
php artisan make:model Reply -mc
php artisan tinker
>>> factory('App\Thread', 50)->create();
php artisan migrate:refresh 
>>> $threads = factory('App\Thread', 50)->create();
>>> $threads->each(function ($thread) { factory('App\Reply', 10)->create(['thread_id' => $thread->id]); });
```

### Episode 2
```bash
php artisan make:auth
```
Add to phpunit.xml
```xml
<server name="DB_CONNECTION" value="sqlite"/>
<server name="DB_DATABASE" value=":memory:"/>
```
Write first test cases

### Episode 3
Added relationship Thread => Reply
```bash
php artisan make:test ReplyTest --unit
```
Added relationship Reply => User 

### Episode 4
Refactor show, added replay.blade.php
```bash
phpunit --filter testThreadHasCreator # run 1 test method from files
php artisan make:test ParticipateInForum
```
Fixed app/Exceptions/Handler.php, added `if (app()->environment() === 'testing') throw $exception;`
```bash
phpunit --filter ThreadTest # run 1 file
```
```php
protected $guarded = [];
```

### Episode 5
```php
@if(auth()->check())
    {{ csrf_field() }}
@else
    <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
@endif
$this->be($user = factory('App\User')->create());
$this->expectException('Illuminate\Auth\AuthenticationException');
```

### Episode 6
```php
$this->middleware('auth')->only('store');
$this->actingAs(factory('App\User')->create());
$this->expectException('Illuminate\Auth\AuthenticationException');
```

### Episode 7
Refactor tests
```json
{
    "autoload": {
        "files": [
            "tests/utilities/functions.php"
        ]
    }
}
```
```bash
composer dump-autoload
```
```php
$this->signIn(); // in TestCase
```