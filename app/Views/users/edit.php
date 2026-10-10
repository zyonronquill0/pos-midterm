<?= view('templates/header') ?>

<h2>Edit User Account & Avatar</h2>

<?php if (isset($validation)): ?>
<div style="padding: 0.75rem 1rem; background: #fee2e2; color: #991b1b; border-radius: 4px; margin-bottom: 1rem;">
    <?= $validation->listErrors() ?>
</div>
<?php endif; ?>

<form action="<?= base_url('users/' . $user['id']) ?>" method="post" enctype="multipart/form-data"
    style="max-width: 500px; margin-top: 1rem;">
    <?= csrf_field() ?>

    <div style="margin-bottom: 1rem;">
        <label for="username" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Username *</label>
        <input type="text" name="username" id="username" value="<?= set_value('username', $user['username']) ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="full_name" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Staff Full Name
            *</label>
        <input type="text" name="full_name" id="full_name" value="<?= set_value('full_name', $user['full_name']) ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Current Avatar</label>
        <?php if (!empty($user['avatar']) && file_exists(FCPATH . 'uploads/avatars/' . $user['avatar'])): ?>
        <img src="<?= base_url('uploads/avatars/' . esc($user['avatar'])) ?>" alt="Current Avatar"
            style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 2px solid #cbd5e1; display: block; margin-bottom: 0.75rem;">
        <?php else: ?>
        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 0.75rem;">No custom avatar uploaded (initials
            placeholder active).</p>
        <?php endif; ?>

        <label for="avatar" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Upload New Avatar (JPG or
            PNG, max 2MB)</label>
        <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png"
            style="width: 100%; padding: 0.4rem; border: 1px solid #cbd5e1; border-radius: 4px;">
    </div>

    <button type="submit"
        style="padding: 0.6rem 1.25rem; background: #0f766e; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500;">Save
        Changes</button>
    <a href="<?= base_url('users') ?>" style="margin-left: 1rem; color: #64748b; text-decoration: none;">Cancel</a>
</form>

<?= view('templates/footer') ?>