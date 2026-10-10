<?= view('templates/header') ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h2>Product Inventory</h2>
    <a href="<?= base_url('products/new') ?>"
        style="background: #0284c7; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-weight: 500;">+
        Add New Product</a>
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
            <th style="padding: 0.75rem 1rem;">Image</th>
            <th style="padding: 0.75rem 1rem;">Product Name</th>
            <th style="padding: 0.75rem 1rem;">Price</th>
            <th style="padding: 0.75rem 1rem;">Stock</th>
            <th style="padding: 0.75rem 1rem;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (! empty($products)): ?>
        <?php foreach ($products as $p): ?>
        <tr style="border-bottom: 1px solid #e2e8f0;">
            <td style="padding: 0.75rem 1rem;">
                <?php if (! empty($p['image']) && file_exists(FCPATH . 'uploads/products/' . $p['image'])): ?>
                <img src="<?= base_url('uploads/products/' . esc($p['image'])) ?>" alt="<?= esc($p['name']) ?>"
                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
                <?php else: ?>
                <div
                    style="width: 50px; height: 50px; background: #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; color: #64748b;">
                    No Img</div>
                <?php endif; ?>
            </td>
            <td style="padding: 0.75rem 1rem; font-weight: 600;"><?= esc($p['name']) ?></td>
            <td style="padding: 0.75rem 1rem;">₱<?= number_format($p['price'], 2) ?></td>
            <td style="padding: 0.75rem 1rem;">
                <span
                    style="display: inline-block; padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: 600; font-size: 0.85rem; <?= $p['stock_quantity'] > 0 ? 'background: #e0f2fe; color: #0369a1;' : 'background: #fee2e2; color: #991b1b;' ?>">
                    <?= esc($p['stock_quantity']) ?> units
                </span>
            </td>
            <td style="padding: 0.75rem 1rem;">
                <a href="<?= base_url('products/' . $p['id'] . '/edit') ?>"
                    style="color: #0284c7; text-decoration: none; margin-right: 1rem; font-weight: 500;">Edit</a>
                <a href="<?= base_url('products/' . $p['id'] . '/delete') ?>"
                    onclick="return confirm('Are you sure you want to delete this product?');"
                    style="color: #ef4444; text-decoration: none; font-weight: 500;">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="5" style="padding: 1.5rem; text-align: center; color: #64748b;">No products found.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= view('templates/footer') ?>