<?= view('templates/header') ?>

<h2>Add New Customer</h2>

<?php if (isset($validation)): ?>
<div style="padding: 0.75rem 1rem; background: #fee2e2; color: #991b1b; border-radius: 4px; margin-bottom: 1rem;">
    <?= $validation->listErrors() ?>
</div>
<?php endif; ?>

<form action="<?= base_url('customers') ?>" method="post" style="max-width: 500px; margin-top: 1rem;">
    <?= csrf_field() ?>

    <div style="margin-bottom: 1rem;">
        <label for="full_name" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Full Name *</label>
        <input type="text" name="full_name" id="full_name" value="<?= set_value('full_name') ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 1rem;">
        <label for="email" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Email Address *</label>
        <input type="email" name="email" id="email" value="<?= set_value('email') ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 1.5rem;">
        <label for="phone" style="display: block; font-weight: 500; margin-bottom: 0.35rem;">Phone Number</label>
        <input type="text" name="phone" id="phone" value="<?= set_value('phone') ?>"
            style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px;">
    </div>

    <button type="submit"
        style="padding: 0.6rem 1.25rem; background: #0284c7; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500;">Save
        Customer</button>
    <a href="<?= base_url('customers') ?>" style="margin-left: 1rem; color: #64748b; text-decoration: none;">Cancel</a>
</form>

<?= view('templates/footer') ?>