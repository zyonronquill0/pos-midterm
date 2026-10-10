<?php

use App\Commands\ResetPassword;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\Mock\MockInputOutput;

final class ResetPasswordTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    private MockInputOutput $io;
    private string $originalHash;

    protected function setUp(): void
    {
        parent::setUp();

        $db = db_connect();
        // Never run these credential tests against an application database.
        $this->assertSame('SQLite3', $db->DBDriver);
        $this->assertSame(':memory:', $db->database);
        $db->query('CREATE TABLE IF NOT EXISTS db_users (id INTEGER PRIMARY KEY, username TEXT, password TEXT, full_name TEXT, avatar TEXT)');
        $db->table('users')->truncate();
        $this->originalHash = password_hash('old-test-password', PASSWORD_DEFAULT);
        $db->table('users')->insertBatch([
            ['id' => 1, 'username' => 'admin', 'password' => $this->originalHash, 'full_name' => 'Test Admin'],
            ['id' => 2, 'username' => 'cashier', 'password' => $this->originalHash, 'full_name' => 'Test Cashier'],
        ]);

        $this->io = new MockInputOutput();
        CLI::setInputOutput($this->io);
    }

    protected function tearDown(): void
    {
        CLI::resetInputOutput();
        parent::tearDown();
    }

    private function resetPassword(array $inputs, string $username = 'admin'): int
    {
        $this->io->setInputs($inputs);
        $command = new ResetPassword(service('logger'), service('commands'));

        return $command->run([$username]);
    }

    private function passwordFor(string $username): string
    {
        return db_connect()->table('users')->where('username', $username)->get()->getRowArray()['password'];
    }

    public function testResetStoresValidHashAndOnlyChangesSelectedAccount(): void
    {
        $password = ' new-test-password ';
        $this->assertSame(EXIT_SUCCESS, $this->resetPassword([$password, $password]));
        $hash = $this->passwordFor('admin');
        $this->assertNotSame($password, $hash);
        $this->assertTrue(password_verify($password, $hash));
        $this->assertFalse(password_verify('old-test-password', $hash));
        $this->assertSame($this->originalHash, $this->passwordFor('cashier'));
    }

    public function testMismatchedConfirmationLeavesPasswordUnchanged(): void
    {
        $this->assertSame(EXIT_ERROR, $this->resetPassword(['new-test-password', 'different-password']));
        $this->assertSame($this->originalHash, $this->passwordFor('admin'));
    }

    public function testShortPasswordLeavesPasswordUnchanged(): void
    {
        $this->assertSame(EXIT_ERROR, $this->resetPassword(['short']));
        $this->assertSame($this->originalHash, $this->passwordFor('admin'));
    }

    public function testOverlongPasswordLeavesPasswordUnchanged(): void
    {
        $this->assertSame(EXIT_ERROR, $this->resetPassword([str_repeat('a', 73)]));
        $this->assertSame($this->originalHash, $this->passwordFor('admin'));
    }

    public function testUnknownUserIsNotCreated(): void
    {
        $this->assertSame(EXIT_ERROR, $this->resetPassword([], 'missing'));
        $this->assertSame(2, db_connect()->table('users')->countAllResults());
        $this->assertSame($this->originalHash, $this->passwordFor('admin'));
    }

    public function testNewPasswordWorksThroughLoginController(): void
    {
        $this->assertSame(EXIT_SUCCESS, $this->resetPassword(['new-test-password', 'new-test-password']));
        $result = $this->withSession([])->post('login', [
            'username' => 'admin',
            'password' => 'new-test-password',
        ]);

        $result->assertRedirectTo(base_url('customers'));
        $result->assertSessionHas('isLoggedIn', true);
        $result->assertSessionHas('username', 'admin');
    }

    public function testOldPasswordIsRejectedThroughLoginController(): void
    {
        $this->assertSame(EXIT_SUCCESS, $this->resetPassword(['new-test-password', 'new-test-password']));
        $result = $this->withSession([])->post('login', [
            'username' => 'admin',
            'password' => 'old-test-password',
        ]);

        $result->assertSessionHas('error', 'Invalid username or password.');
        $this->assertNotTrue(session()->get('isLoggedIn'));
    }
}
