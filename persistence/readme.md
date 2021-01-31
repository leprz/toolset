# Persistence

#### A little tests theory:

This repository shows integration testing approach where the unit of test is whole user use case. 
> Integration tests determine if independently developed units of software work correctly when they are connected to each other.

I'll focus mostly on end to end testing.
> End to end (E2E) testing is a software testing method that ensures an application works as expected for the end user by
> testing the **different flows** that a user might take **from beginning to end**.

Usually we describe use case scenarios by functional requirements.
 
> A functional requirement is a requirement that specifies a function that a system or system component must perform.
> Is described as a specification of behavior between outputs and inputs.

The goal of e2e tests is to check all system functional requirements. 
This includes checking positive and negative test path.

## Problem 1 - decoupling repository responsibilities 

Very often repository has methods:

|           |       |
| --------- | ----- |
| getForId  | read  |
| getAll    | read  |
| add       | write |
| remove    | write |
| save      | write |

#### Example:

We have given multiple use case scenarios to test.
One of the easiest ways is to use fixtures to get the test data and then save the result to the data store.
The problem is that we don't want pollute data storage by the tests.
In perfect scenario we want to run one test multiple times without seeding the fixtures again each time.
Simples way to do that is to use repository mock and just check if method `->save(...)` has been fired without
actual saving anything to the data store. This solves one issue but lead to another one.
Because we mocked whole repository, we can't use data fixtures anymore. Method `->getForId(...)` is mocked too.
We can prepare test data and return it in mocked method `->method('getForId')->willReturn(...)`. 
Unfortunately this makes our tests very clumsy and will skip very important part of the test. 
Not tested queries may be a source of bugs. 
Testing data store under specific input variables is very important.

#### Solution:

Decouple methods for querying data from methods that modify data state.
```php
interface CustomerRepositoryInterface
{
    public function getForId(CustomerId $customerId): Customer;
}
```
from
```php
interface CustomerPersistenceInterface
{
    public function add(Customer $customer): void;
    public function save(Customer $customer): void;
    public function remove(Customer $customer): void;
}
```
now we are able to mock `CustomerPersistenceInterface` 
but still use real implementation of `CustomerRepositoryInterface`

Checking if customer has been added is simple as that:
```php
private function assertCustomerHasBeenPersisted(): void
{
    $this->persistenceMock->expects(self::once())->method('add');
}
``` 
To check more complex things like updates you can use this:
```php
private function assertEmailHasBeenChanged(Email $newEmail): void
{
    $this->customerPersistenceMock->expects(self::once())
        ->method('save')->with(
            self::callback(
                function (Customer $customer) use ($newEmail): bool {
                    return CustomerGetter::getEmail($customer)->equals($newEmail);
                }
            )
        );
}
```

#### Advantages:
- Various use case scenarios can be easily tested.
- Write methods can be unit tested separately.
- Test cover getting the data from data store (very important in relational databases where query may return wrong
results under specific search conditions)
- Tests do not pollute data store.
- Test can be run multiple times without re-seeding the fixtures.

## Problem 2 - data store clean up

#### Example:

In some circumstances e2e tests require data to be persisted in the data store. 
E.g. to check constraints or database triggers.
This lead to challenge how to clean up data store after the test.
If we use `new Uuid()` or similar methods of generating ids inside our application we never know what
has been generated.  

#### Solution
Use id generators.

We can use factory methods for generating next identifier.
This may be numeric value or globally unique identifier (Guid).
```php
public function generateNextId(): CustomerId
{
    return $this->idGenerator->generate();
}
```
Thanks to that we can easily substitute `idGenerator` in tests and collect all generated ids for entity:
```php
class FakeCustomerIdGenerator extends CustomerIdGenerator
{
    private array $generatedIds = [];
    
    public function generate(): CustomerId
    {
        $this->generatedIds[] = $generatedId = parent::generate();
    
        return $generatedId;
    }
    ...
}
```
Assertion may look like this.

`getForId` throws exception if entity has been not found.
```php
private function assertCustomersWereImported(): void
{
    $generatedIds = $this->customerIdGenerator->getGeneratedIds();
    foreach ($generatedIds as $customerId) {
        $customer = $this->repository->getForId($customerId);

        $this->savedCustomers[] = $customer;
    }

    self::assertCount(2, $this->savedCustomers);
}
```
Database cleanup may look like this
```php
private function databaseCleanUp(): void
{
    foreach ($this->savedCustomers as $customer) {
        $this->persistence->remove($customer);
    }
}
```

## Useful Tips
- Using Uuid or Guid instead of auto generated ids makes system much easier to maintain.
- Using InMemoryRepository instead of real data store will not discover bugs related to query malfunction. 
- Having a good base of fixtures makes work of manual testers much easier and give appealing look to the system.
(having a nice system without any data makes it look poor)

## Resources
- [E2E](https://www.browserstack.com/guide/end-to-end-testing)
- [Integration test](https://martinfowler.com/bliki/IntegrationTest.html)
- [Command Pattern](https://wiki.c2.com/?CommandPattern)
- [Guid](https://proxy.c2.com/cgi/wiki?GloballyUniqueIdentifier)
