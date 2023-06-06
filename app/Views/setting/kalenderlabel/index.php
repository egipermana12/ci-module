<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<div class="card">
    <div class="card-header">
        <div class="text-uppercase fs-6 fw-medium">
            kalender Label
        </div> 
        <div class="py-1">
            <a href="<?=$config->baseURL?>setting/labelkalender" class="btn btn-outline-success btn-sm"><i class="fas fa-plus pe-1"></i> Add Label</a>
        </div> 
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Label</th>
                        <th>Warna Label</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?=$this->endSection()?>
