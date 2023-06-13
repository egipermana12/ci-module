<?=$this->extend('template/header.php')?>
<?=$this->section('content')?>
<div class="card">
    <div class="card-header">
        <div class="text-uppercase fs-6 fw-medium">
            kalender Label
        </div> 
        <!-- <div class="py-1">
            <a href="#" class="btn btn-outline-success btn-sm"><i class="fas fa-plus pe-1"></i> Add Label</a>
        </div>  -->
    </div>
    <div class="card-body">
        <div class="table-responsive px-3">
            <table class="table table-striped table-bordered table-hover" id="data-tables">
                <thead>
                    <tr>
                        <th class="text-center" width="10%">No</th>
                        <th class="text-center" width="60%">Nama Label</th>
                        <th class="text-center" width="10%">Warna Label</th>
                        <th class="text-center" width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                   <!-- pindah ke controller -->
                <?php
                        //untuk parsing ke js calender-data-table.js setting datatables 
                $settings['order'] = [1,'asc'];              
                $settings['columnDefs'][] = ['targets' => [0, 2, 3], 'orderable' => false];
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>


<div class="tampilModal" style="display: none;"></div>
<span id="dataTables-setting" style="display:none"><?=json_encode($settings)?></span>
<?=$this->endSection()?>
