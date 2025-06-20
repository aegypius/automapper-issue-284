# jolicode/automapper#284

It seems than the "Auto" constructor strategy struggle with this kind of readonly inheritence.

```php
readonly class Fruit
{
   public function __construct(
      public int $weight
   ) {}
}

final readonly class Banana extends Fruit {}
```

After deserialisation the "Banana" instance as not been correctly populated and a runtime error is raised :

```
Typed property Fruit::$weight must not be accessed before initialization
```

See [tests/](tests/)
