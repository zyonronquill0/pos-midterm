<?= view('templates/header') ?>

<div style="max-width: 420px; margin: 3rem auto; padding: 2rem; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0;">
    <h2 style="margin-top: 0; text-align: center; color: #0f172a; margin-bottom: 1.5rem;">Sign In to POS</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div style="padding: 0.75rem 1rem; background: #fee2e2; color: #991b1b; border-radius: 4px; margin-bottom: 1rem; font-size: 0.9rem;">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('message')): ?>
        <div style="padding: 0.75rem 1rem; background: #dcfce7; color: #166534; border-radius: 4px; margin-bottom: 1rem; font-size: 0.9rem;">
            <?= esc(session()->getFlashdata('message')) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
        <div style="padding: 0.75rem 1rem; background: #fee2e2; color: #991b1b; border-radius: 4px; margin-bottom: 1rem; font-size: 0.9rem;">
            <?= $validation->listErrors() ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <div style="margin-bottom: 1rem;">
            <label for="username" style="display: block; font-weight: 500; margin-bottom: 0.35rem; color: #334155;">Username</label>
            <input type="text" name="username" id="username" value="<?= set_value('username') ?>" style="width: 100%; padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;" required autofocus>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="password" style="display: block; font-weight: 500; margin-bottom: 0.35rem; color: #334155;">Password</label>
            <input type="password" name="password" id="password" style="width: 100%; padding: 0.55rem; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;" required>
        </div>

        <button type="submit" style="width: 100%; padding: 0.7rem; background: #0284c7; color: white; border: none; border-radius: 4px; font-weight: 600; cursor: pointer;">Log In</button>
    </form>
</div>

<?= view('templates/footer') ?>