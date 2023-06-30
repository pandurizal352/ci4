<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Contact us</h2>
            <!--looping ngambil dari controler-->
            <?php foreach ($alamat as $a) : ?>
                <ul>
                    <li> <?= $a['tipe']; ?></li>
                    <li> <?= $a['alamat']; ?></li>
                    <li> <?= $a['Kota']; ?></li>
                </ul>
            <?php endforeach; ?>

        </div>
    </div>
</div>
<?= $this->endSection(); ?>