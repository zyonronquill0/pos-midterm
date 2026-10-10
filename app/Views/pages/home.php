<?= view('templates/header') ?>

<h2>Point-of-Sale System Dashboard</h2>
<p>Welcome to the first version of the CodeIgniter 4 POS application.</p>
<p>This phase implements the routing and controller layers along with static data structures.</p>

<div style="margin-top: 25px; display: flex; gap: 12px;">
    <a href="<?= base_url('/customers') ?>"
        style="padding: 10px 18px; background: #0284c7; color: white; text-decoration: none; border-radius: 6px; font-weight: 500;">Manage
        Customers</a>
    <a href="<?= base_url('/users') ?>"
        style="padding: 10px 18px; background: #0f766e; color: white; text-decoration: none; border-radius: 6px; font-weight: 500;">Manage
        Staff Users</a>
</div>

<?= view('templates/footer') ?>