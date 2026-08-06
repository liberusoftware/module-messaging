<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Liberu\Messaging\Core\Models\Message;
use Liberu\Messaging\Core\Policies\MessagePolicy;

/**
 * Lifted out of the host's `tests/Unit/ModuleSupportCoverageTest.php`, which
 * covered one method of one class per package. The policy takes an
 * `Authenticatable` and an unsaved model, so it needs neither a database nor a
 * user model — the shared `PackageTestCase` is enough.
 */
it('authorizes message participants', function () {
    $actor = Mockery::mock(Authenticatable::class);
    $actor->shouldReceive('getAuthIdentifier')->andReturn(10);
    $message = new Message(['sender_id' => 10, 'recipient_id' => 20]);
    $other = new Message(['sender_id' => 30, 'recipient_id' => 40]);
    $policy = new MessagePolicy();

    expect($policy->viewAny($actor))->toBeTrue()
        ->and($policy->create($actor))->toBeTrue()
        ->and($policy->view($actor, $message))->toBeTrue()
        ->and($policy->view($actor, $other))->toBeFalse()
        ->and($policy->update($actor, $message))->toBeTrue()
        ->and($policy->update($actor, $other))->toBeFalse()
        ->and($policy->delete($actor, $message))->toBeTrue()
        ->and($policy->delete($actor, $other))->toBeFalse();
});
