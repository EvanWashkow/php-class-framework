# PHP Class Framework

## \PHP\ClassFramework\Autoloader

Autoload classes in the class namespace chain

```
new \PHP\ClassFramework\Autoloader( 'MyClass', __DIR__ . '/MyClass' );

class MyClass
{
    
    public static function MyFunction()
    {
        // Auto-loads class from current namespace directory
        \MyClass\MySubClass::DoWork();
        \MyClass\MySubClass\SomeOtherClass::DoMoreWork();
    }
}
```

Where your class and directory structure looks like this:

```
MyClass.php
MyClass/
    MySubClass.php
    MySubClass/
        SomeOtherClass.php
```
