# PHP Class Framework

## General structure

```
MyClass.php
MyClass/
    MySubClass.php
    MySubClass/
        SomeOtherClass.php
```


## \PHP\ClassFramework\Autoloader

Automatically load classes from the namespace directory

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


## \PHP\ClassFramework\FrameworkClass

Natural extension of the Autoloader, but provides helpers for the current class, such as loading component classes / files.

```
class MyClass extends \PHP\ClassFramework\FrameworkClass
{
    public static function MyFunction()
    {
        // Load classes / files from the current directory
        self::include([
            'MySubClass',
            'MySubClass/SomeOtherClass'
        ]);
    }
}
```
