<?= view('templates/header') ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2>User Accounts</h2>
    <a href="<?= base_url('users/new') ?>" style="padding: 0.5rem 1rem; background: #0f766e; color: white; text-decoration: none; border-radius: 4px; font-weight: 500;">+ Add New User</a>
</div>

<?php if (session()->getFlashdata('message')): ?>
    <div style="padding: 0.75rem 1rem; background: #dcfce7; color: #166534; border-radius: 4px; margin-bottom: 1rem;">
        <?= esc(session()->getFlashdata('message')) ?>
    </div>
<?php endif; ?>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: #f1f5f9; text-align: left;">
            <th style="padding: 0.75rem;">Avatar</th>
            <th style="padding: 0.75rem;">ID</th>
            <th style="padding: 0.75rem;">Username</th>
            <th style="padding: 0.75rem;">Full Name</th>
            <th style="padding: 0.75rem;">Created Date</th>
            <th style="padding: 0.75rem;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $u): ?>
                <tr style="border-bottom: 1px solid #e2e8f0; vertical-align: middle;">
                    <td style="padding: 0.75rem;">
                        <?php if (!empty($u['avatar']) && file_exists(FCPATH . 'uploads/avatars/' . $u['avatar'])): ?>
                            <img src="<?= base_url('uploads/avatars/' . esc($u['avatar'])) ?>" alt="Avatar" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid #cbd5e1; display: block;">
                        <?php else: ?>
                            <div style="width: 44px; height: 44px; border-radius: 50%; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem;">
                                <?= esc(strtoupper(substr($u['username'], 0, 2))) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 0.75rem;"><?= esc($u['id']) ?></td>
                    <td style="padding: 0.75rem;"><code><?= esc($u['username']) ?></code></td>
                    <td style="padding: 0.75rem; font-weight: 500;"><?= esc($u['full_name']) ?></td>
                    <td style="padding: 0.75rem;"><?= esc($u['created_at']) ?></td>
                    <td style="padding: 0.75rem;">
                        <a href="<?= base_url('users/' . $u['id'] . '/edit') ?>" style="color: #0f766e; font-weight: 500; text-decoration: none;">Edit Profile</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="padding: 1rem; text-align: center; color: #64748b;">No user accounts found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= view('templates/footer') ?>