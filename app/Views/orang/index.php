<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <h1 class="mt-2">Daftar orang</h1>
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="masukan key pencarian.." name="keyword">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2" name="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <!-- <a href="/komik/create" class="btn btn-primary mb-3"> Tambah data</a> -->
            <!-- alertnya misal kalau set buat bikin get buat ngambil -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (5 * ($currentPage - 1)); ?>
                    <?php foreach ($orang as  $o) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $o['nama']; ?></td>
                            <td><?= $o['alamat']; ?></td>
                            <td>
                                <a href="" class="btn btn-success">Detail</a>

                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('orang', 'orang_pagination'); ?>
            <!-- orang adalah nama tabel dan orang_pagination adalah nama file nya  -->
        </div>
    </div>
</div>

<?= $this->endSection(); ?>