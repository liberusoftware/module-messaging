<?php

namespace Liberu\Messaging\Core\Tests;

use Liberu\PackageTestbench\PackageTestCase;
use Liberu\PackageTestbench\TestUser;
use Liberu\PackageTestbench\UsesTestUser;

/**
 * A message is a row between two users, so the suite needs a `users` table and
 * a model to point at — neither of which this package owns. `UsesTestUser`
 * supplies both, and brings `RefreshDatabase` with it; the `messages` migration
 * carries a foreign key onto `users`, so the table has to exist first.
 *
 * `auth.providers.users.model` is what `Message::sender()`, `Message::recipient()`
 * and `MessageFactory` all resolve against — the package never names a user class
 * itself, which is exactly why a test can substitute one.
 *
 * `parent::defineEnvironment($app)` is not optional: it sets the application key,
 * and every message body in this package is `Crypt`-encrypted at rest.
 */
abstract class TestCase extends PackageTestCase
{
    use UsesTestUser;

    protected function defineEnvironment($app): void
    {
        parent::defineEnvironment($app);

        $app['config']->set('auth.providers.users.model', TestUser::class);
    }
}
