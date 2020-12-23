Value Object
---

A Value Object is an [immutable](https://wiki.c2.com/?ImmutableObject) type that is distinguishable only by the state of its properties.
That is, unlike an Entity, which has a unique identifier and remains distinct even if its properties are otherwise identical.

### Immutability
Value Objects cannot be changed once they are created.
```php
$twoDollars = new Money::fromMainUnit(2.00, new Currency('USD')); // $2.00
$bookPriceBeforeDiscount = $twoDollars;

$twoDollars->setAmountInMainUnit(1.00); // This is bad: it is not two dollars anymore, it's a $oneDollar
$bookPriceAfterDiscount = $twoDollars; // Now the book price before discount is worth $1.00 because object was assigned by reference
```
Modifying one is conceptually the same as discarding the old one and creating a new one.
```php
$twoDollars = new Money::fromMainUnit(2.00, new Currency('USD'));
$bookPriceBeforeDiscount = $twoDollars;

$oneDollar = new Money::fromMainUnit(1.00, new Currency('USD')); // This is good
$bookPriceAfterDiscount = $oneDollar;
```

### Validity
Value Objects guards instance validity. All created instances must be valid.

Consider that every email is a string but not every string is an email.
```php
$email = 'email'; // This is bad: invalid email has been saved to variable

$email = new Email('email'); // This is good: It will throw exception because email is invalid
```

### Equality
Two Value Objects with the exact same properties can be considered equal.

Let's imagine a [Battleship game](https://en.wikipedia.org/wiki/Battleship_(game)):
```php
$shipPosition = new PositionOnGrid('A', 2);
$targetPosition = new PositionOnGrid('A', 2);

$shipPosition->equals($targetPosition); // true - that's a hit
```

### Special Behaviour
Let's consider money subtraction:
```php
$threeDollars = new Money::fromMainUnit(3.00, new Currency('USD'));
$oneDollar = new Money::fromMainUnit(1.00, new Currency('USD'));

$twoDollars = $threeDollars->subtract($oneDollar); // because Money is immutable it'll create a new instance
```
Subtracting money with different currencies will throw an exception.
```php
$oneEuro = new Money::fromMainUnit(1.00, new Currency('EUR'));
$oneDollar = new Money::fromMainUnit(1.00, new Currency('USD'));

$error = $oneEuro->subtract($oneDollar); // this will thrown an exception
```

### Useful tips
Consider using Auto Encapsulation by using private setters.
Keeping all assertions in the setter will clean up code a little. Especially when there are multiple properties.
```php
final class Currency 
{
    ...
    private function __construct(string $currency)
    {
        $this->setCurrency($currency);
    }
    
    private function setCurrency(string $currency): void
    {
        $currency = strtoupper($currency);
    
        self::assertLength($currency);
        self::assertFormat($currency);
    
        $this->currency = $currency;
    }
    ...
}
```
Use [psalm helper annotations](https://psalm.dev/articles/immutability-and-beyond)
```php
/**
 * @psalm-immutable
 */
final class Currency
```
## Resources
- [Immutability](https://wiki.c2.com/?ImmutableObject)
- [Value Object examples](https://verraes.net/2011/04/fowler-money-pattern-in-php/)
- [Value Object theory](https://deviq.com/value-object/)
- [Psalm Immutability helpers](https://psalm.dev/articles/immutability-and-beyond)
- [Battleship game](https://en.wikipedia.org/wiki/Battleship_(game))
