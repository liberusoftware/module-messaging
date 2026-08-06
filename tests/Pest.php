<?php

use Liberu\Messaging\Core\Tests\TestCase;
use Liberu\PackageTestbench\PackageTestCase;

// Only the feature suite needs a database and an actor; the rest boot the package
// and nothing else, so they take the shared case directly.
pest()->extend(PackageTestCase::class)->in('Architecture', 'Integration', 'Unit');
pest()->extend(TestCase::class)->in('Feature');
