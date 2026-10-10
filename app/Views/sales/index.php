<?= view('templates/header') ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2>Sales History</h2>
    <a href="<?= base_url('sales/new') ?>"
        style="background: #0284c7; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-weight: 500;">+
        Record New Sale</a>
</div>

<?php if (session()->getFlashdata('message')): ?>
<div style="padding: 0.75rem 1rem; background: #dcfce7; color: #166534; border-radius: 4px; margin-bottom: 1rem;">
    <?= esc(session()->getFlashdata('message')) ?>
</div>
<?php endif; ?>

<table
    style="width: 100%; border-collapse: collapse; background: white; border-radius: 6px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <thead>
        <tr style="background: #0f172a; color: white; text-align: left;">
            <th style="padding: 0.75rem 1rem;">ID</th>
            <th style="padding: 0.75rem 1rem;">Date & Time</th>
            <th style="padding: 0.75rem 1rem;">Product</th>
            <th style="padding: 0.75rem 1rem;">Customer</th>
            <th style="padding: 0.75rem 1rem;">Sold By</th>
            <th style="padding: 0.75rem 1rem;">Qty</th>
            <th style="padding: 0.75rem 1rem;">Total Price</th>
        </tr>
    </thead>
    <tbody>
        <?php if (! empty($sales)): ?>
        <?php foreach ($sales as $s): ?>
        <tr style="border-bottom: 1px solid #e2e8f0;">
            <td style="padding: 0.75rem 1rem; color: #64748b;">#<?= esc($s['id']) ?></td>
            <td style="padding: 0.75rem 1rem; font-size: 0.9rem;">
                <?= esc(date('M d, Y h:i A', strtotime($s['created_at']))) ?></td>
            <td style="padding: 0.75rem 1rem; font-weight: 600;"><?= esc($s['product_name']) ?></td>
            <td style="padding: 0.75rem 1rem;">
                <?= ! empty($s['customer_name']) ? esc($s['customer_name']) : '<span style="color: #94a3b8; font-style: italic;">Walk-in</span>' ?>
            </td>
            <td style="padding: 0.75rem 1rem;"><?= esc($s['staff_name']) ?></td>
            <td style="padding: 0.75rem 1rem; font-weight: 600;"><?= esc($s['quantity']) ?></td>
            <td style="padding: 0.75rem 1rem; font-weight: 700; color: #0284c7;">
                ₱<?= number_format($s['total_price'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="7" style="padding: 1.5rem; text-align: center; color: #64748b;">No sales transactions recorded
                yet.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= view('templates/footer') ?>