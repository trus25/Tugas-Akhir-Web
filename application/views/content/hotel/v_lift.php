<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Akses Lift
        <small>Akses Lift</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Akses Lift</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lift Panel</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="durasiPr" class="table table-bordered table-striped table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                      <th class="col-md-3" style="text-align:center">Lift ID</th>
                      <th class="col-md-3" style="text-align:center">Lokasi Lift</th>
                      <th class="col-md-6" style="text-align:center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php 
                          foreach ($lift as $lf) {
                            echo '<tr>
                                    <th style="vertical-align:middle;text-align:center;">'.$lf->l_id.'</th>
                                    <th style="vertical-align:middle;text-align:center;">'.$lf->l_lokasi.'</th>
                                    <td style="text-align:center">';
                                      if($lf->l_status == '0'){
                                        echo '<button style="width:100px;font-weight:bold" value="1" id="'.$lf->l_id.'" class="lift btn btn-primary btn-md"><b>AKTIFKAN</b></button>';
                                      }else if($lf->l_status == '1'){
                                        echo '<button style="width:100px;font-weight:bold" value="0" id="'.$lf->l_id.'" class="lift btn btn-danger btn-md">MATIKAN</button>';
                                      }
                            echo    '</td>
                                  </tr>';
                      }?>
                      
                    </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

