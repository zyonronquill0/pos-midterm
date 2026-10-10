<?= view('templates/header') ?>

<h2>Record a Sale</h2>

<?php if (session()->getFlashdata('error')): ?>
    <div style="padding: 0.75rem 1rem; background: #fee2e2; color: #991b1b; border-radius: 4px; margin-bottom: 1rem; max-width: 500px;">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('sales') ?>" method="post" style="max-width: 500px; margin-top: 1rem; background: white; padding: 1.5rem; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <?= csrf_field() ?>

    <div style="margin-bottom: 1rem;">
        <label for="product_id" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Select Product *</label>
        <select name="product_id" id="product_id" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;" required>
            <option value="">-- Choose In-Stock Product --</option>
            <?php foreach ($products as $p): ?>
                <option value="<?= esc($p['id']) ?>" <?= set_select('product_id', $p['id']) ?>>
                    <?= esc($p['name']) ?> (₱<?= number_format($p['price'], 2) ?>) — Available: <?= esc($p['stock_quantity']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="customer_id" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Customer (Optional)</label>
        <select name="customer_id" id="customer_id" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;">
            <option value="">-- Walk-in / Anonymous Customer --</option>
            <?php foreach ($customers as $c): ?>
                <option value="<?= esc($c['id']) ?>" <?= set_select('customer_id', $c['id']) ?>>
                    <?= esc($c['full_name']) ?> (<?= esc($c['email']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="quantity" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Quantity to Sell *</label>
        <input type="number" name="quantity" id="quantity" min="1" value="<?= set_value('quantity', '1') ?>" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;" required>
    </div>

    <button type="submit" style="padding: 0.6rem 1.25rem; background: #0284c7; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500;">Confirm & Complete Sale</button>
    <a href="<?= base_url('sales') ?>" style="margin-left: 1rem; color: #64748b; text-decoration: none;">Cancel</a>
</form>

<?= view('templates/footer') ?>
