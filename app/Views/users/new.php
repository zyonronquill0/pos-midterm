<?= view('templates/header') ?>

<h2>Add New User Account</h2>

<?php if (isset($validation)): ?>
<div style="padding: 0.75rem 1rem; background: #fee2e2; color: #991b1b; border-radius: 4px; margin-bottom: 1rem;">
    <?= $validation->listErrors() ?>
</div>
<?php endif; ?>

<form action="<?= base_url('users') ?>" method="post" style="max-width: 500px; margin-top: 1rem;">
    <?= csrf_field() ?>

    <div style="margin-bottom: 1rem;">
        <label for="username" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Username *</label>
        <input type="text" name="username" id="username" value="<?= set_value('username') ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;" required>
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="full_name" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Staff Full Name
            *</label>
        <input type="text" name="full_name" id="full_name" value="<?= set_value('full_name') ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;" required>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="password" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Initial Password
            *</label>
        <input type="password" name="password" id="password"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;" required>
    </div>

    <button type="submit"
        style="padding: 0.6rem 1.25rem; background: #0f766e; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500;">Create
        User</button>
    <a href="<?= base_url('users') ?>" style="margin-left: 1rem; color: #64748b; text-decoration: none;">Cancel</a>
</form>

<?= view('templates/footer') ?>