### Adding Script Variables in Evolutly Front End

```php
window.Evoluty = <?php echo json_encode(array_merge(
    Evoluty::scriptVariables(), [
        'custom' => 'value'
        'another-custom-value' => 'value'
    ]
)); ?>

```

By Default it Only Returns an Array of 

```php
return [
    'csrfToken' => csrf_token(),
    'env' => config('app.env'),
];
```

### Adding Commands Specific to Evolutly
Go To:
`./modules/evolutly/Console/Commands`

Add New Command
```php
if ($this->app->runningInConsole()) {
            $this->commands([
                VersionCommand::class,
                // Add Other Console Commands Here
                // App\Console\Commands\GetUpdateCommand
            ]);
        }
```
Create the Console Command
```php
php artisan make:command GetUpdateCommand --command=evo:update
```