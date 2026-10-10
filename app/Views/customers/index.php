<?= view('templates/header') ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2>Customer Accounts</h2>
    <a href="<?= base_url('customers/new') ?>"
        style="padding: 0.5rem 1rem; background: #0284c7; color: white; text-decoration: none; border-radius: 4px; font-weight: 500;">+
        Add New Customer</a>
</div>

<?php if (session()->getFlashdata('message')): ?>
<div style="padding: 0.75rem 1rem; background: #dcfce7; color: #166534; border-radius: 4px; margin-bottom: 1rem;">
    <?= esc(session()->getFlashdata('message')) ?>
</div>
<?php endif; ?>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: #f1f5f9; text-align: left;">
            <th style="padding: 0.75rem;">ID</th>
            <th style="padding: 0.75rem;">Full Name</th>
            <th style="padding: 0.75rem;">Email</th>
            <th style="padding: 0.75rem;">Phone</th>
            <th style="padding: 0.75rem;">Registered Date</th>
            <th style="padding: 0.75rem;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($customers)): ?>
        <?php foreach ($customers as $c): ?>
        <tr style="border-bottom: 1px solid #e2e8f0;">
            <td style="padding: 0.75rem;"><?= esc($c['id']) ?></td>
            <td style="padding: 0.75rem; font-weight: 500;"><?= esc($c['full_name']) ?></td>
            <td style="padding: 0.75rem;"><?= esc($c['email']) ?></td>
            <td style="padding: 0.75rem;"><?= esc($c['phone'] ?? '—') ?></td>
            <td style="padding: 0.75rem;"><?= esc($c['created_at']) ?></td>
            <td style="padding: 0.75rem;">
                <a href="<?= base_url('customers/' . $c['id'] . '/edit') ?>"
                    style="color: #0284c7; font-weight: 500; text-decoration: none;">Edit</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="6" style="padding: 1rem; text-align: center; color: #64748b;">No customer accounts found.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= view('templates/footer') ?>