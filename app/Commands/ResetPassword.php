<?php

namespace App\Commands;

use App\Models\UserModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ResetPassword extends BaseCommand
{
    protected $group       = 'Authentication';
    protected $name        = 'auth:reset-password';
    protected $description = 'Set a new password for an existing user in the configured database.';
    protected $usage       = 'auth:reset-password <username>';
    protected $arguments   = ['username' => 'The existing account to update.'];

    public function run(array $params)
    {
        if (count($params) !== 1 || trim((string) $params[0]) === '') {
            $this->showHelp();
            return EXIT_ERROR;
        }

        $db = db_connect();
        CLI::write('Database: ' . $db->database);

        if (! $db->tableExists('users') || ! $db->fieldExists('password', 'users')) {
            CLI::error('The users table needs a password column before passwords can be set.');
            return EXIT_ERROR;
        }

        $users = new UserModel($db);
        $user = $users->where('username', trim((string) $params[0]))->first();

        if (! $user) {
            CLI::error('User not found. Check the username and database settings in .env.');
            return EXIT_ERROR;
        }

        CLI::write('Resetting password for: ' . $user['username']);
        CLI::write('Password input is visible in this terminal.');
        CLI::print('New password: ');
        $password = rtrim(CLI::input(), "\r\n");

        if (mb_strlen($password) < 6 || strlen($password) > 72 || str_contains($password, "\0")) {
            CLI::error('Use at least 6 characters, at most 72 bytes, and no null characters.');
            return EXIT_ERROR;
        }

        CLI::print('Confirm new password: ');
        $confirmation = rtrim(CLI::input(), "\r\n");
        if ($password !== $confirmation) {
            CLI::error('Passwords do not match. No changes were made.');
            return EXIT_ERROR;
        }

        if (! $users->update($user['id'], ['password' => password_hash($password, PASSWORD_DEFAULT)])) {
            CLI::error('Could not update the password.');
            return EXIT_ERROR;
        }

        CLI::write('Password updated. Log in with this username and your new password.', 'green');
        return EXIT_SUCCESS;
    }
}
