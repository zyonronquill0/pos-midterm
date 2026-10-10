<?= view('templates/header') ?>

<h2>Edit Product</h2>

<?php if (isset($validation)): ?>
<div style="padding: 0.75rem 1rem; background: #fee2e2; color: #991b1b; border-radius: 4px; margin-bottom: 1rem;">
    <?= $validation->listErrors() ?>
</div>
<?php endif; ?>

<form action="<?= base_url('products/' . $product['id']) ?>" method="post" enctype="multipart/form-data"
    style="max-width: 500px; margin-top: 1rem; background: white; padding: 1.5rem; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <?= csrf_field() ?>

    <div style="margin-bottom: 1rem;">
        <label for="name" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Product Name *</label>
        <input type="text" name="name" id="name" value="<?= set_value('name', $product['name']) ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;" required>
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="price" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Price (₱) *</label>
        <input type="number" step="0.01" name="price" id="price" value="<?= set_value('price', $product['price']) ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;" required>
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="stock_quantity" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Stock Quantity
            *</label>
        <input type="number" name="stock_quantity" id="stock_quantity"
            value="<?= set_value('stock_quantity', $product['stock_quantity']) ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;" required>
    </div>

    <?php if (! empty($product['image']) && file_exists(FCPATH . 'uploads/products/' . $product['image'])): ?>
    <div style="margin-bottom: 1rem;">
        <label style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Current Image</label>
        <img src="<?= base_url('uploads/products/' . esc($product['image'])) ?>" alt="<?= esc($product['name']) ?>"
            style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
    </div>
    <?php endif; ?>

    <div style="margin-bottom: 1.5rem;">
        <label for="image" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Change Image (JPG/PNG, max
            2MB)</label>
        <input type="file" name="image" id="image" accept="image/*"
            style="width: 100%; padding: 0.4rem; border: 1px solid #cbd5e1; border-radius: 4px;">
    </div>

    <button type="submit"
        style="padding: 0.6rem 1.25rem; background: #0284c7; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500;">Update
        Product</button>
    <a href="<?= base_url('products') ?>" style="margin-left: 1rem; color: #64748b; text-decoration: none;">Cancel</a>
</form>

<?= view('templates/footer') ?>