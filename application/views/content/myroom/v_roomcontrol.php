<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Room Control
        <small>Room Control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Room Control</li>
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
              <h3 class="box-title">Room Control</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <div class="row">
                <div class="col-md-8 form-horizontal">
                  <div class="form-group">
                    <label class="col-md-3 control-label" style="text-align: left;">ID Kamar</label>
                    <label id="idkamar" idkamar = "<?php echo $idkamar; ?>" class="col-md-3 control-label" style="text-align: left;">:  <?php echo $idkamar; ?></label>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label" style="text-align: left;">Nomor Kamar</label>
                    <label class="col-md-3 control-label" style="text-align: left;">:  <?php echo $nomorkamar; ?></label>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label" style="text-align: left;">Nama Pengunjung</label>
                    <label class="col-md-3 control-label" style="text-align: left;">:  <?php echo $pengunjung; ?></label>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label" style="text-align: left;">Check In</label>
                    <label class="col-md-3 control-label" style="text-align: left;">:  <?php echo $checkin; ?></label>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label" style="text-align: left;">Check Out</label>
                    <label class="col-md-3 control-label" style="text-align: left;">:  <?php echo $checkout; ?></label>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label" style="text-align: left;">Status</label>
                    <label class="col-md-3 control-label" style="text-align: left;">:  <?php echo $status; ?></label>
                  </div>
                </div>
              </div>
                <!-- /.row -->

              <table id="durasiPr" class="table table-bordered table-striped table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                      <th class="col-md-3" style="text-align:center">Perankat</th>
                      <th class="col-md-3" style="text-align:center">Status</th>
                      <th class="col-md-6" style="text-align:center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr>
                          <th style="vertical-align:middle;">Pintu</th>
                          <th style="vertical-align:middle;text-align:center;">
                          <?php
                            if($statuspintu == '0'){
                              echo '<span style="width:100px" class="txpintu badge bg-red">TUTUP';
                            }else if($statuspintu == '1'){
                              echo '<span style="width:100px" class="txpintu badge bg-green">BUKA';
                            }
                          ?>
                            </span>
                          </th>
                          <td style="text-align:center">
                            <?php
                            if($statuspintu == '0'){
                              echo '<button style="width:100px" value="1" class="pintu btn btn-primary btn-md"><b>BUKA</b></button>';
                            }else if($statuspintu == '1'){
                              echo '<button style="width:100px" value="0" class="pintu btn btn-danger btn-md"><b>TUTUP</b></button>';
                            }
                          ?>
                          </td>
                      </tr>
                      <tr>
                          <th style="vertical-align:middle;">Lampu</th>
                          <th style="vertical-align:middle;text-align:center;">
                          <?php
                            if($statuslampu == '0'){
                              echo '<span style="width:100px" class="txlampu badge bg-red">MATI';
                            }else if($statuslampu == '1'){
                              echo '<span style="width:100px" class="txlampu badge bg-green">HIDUP';
                            }
                          ?>
                            </span>
                          </th>
                          <td style="text-align:center">
                            <?php
                            if($statuslampu == '0'){
                              echo '<button style="width:100px" value="1" class="lampu btn btn-primary btn-md"><b>HIDUPKAN</b></button>';
                            }else if($statuslampu == '1'){
                              echo '<button style="width:100px" value="0" class="lampu btn btn-danger btn-md"><b>MATIKAN</b></button>';
                            }
                          ?>
                          </td>
                      </tr>
                      <tr>
                          <th style="vertical-align:middle;">Kipas</th>
                          <th style="vertical-align:middle;text-align:center;">
                          <?php
                            if($statuskipas == '0'){
                              echo '<span style="width:100px"class="txkipas badge bg-red">MATI';
                            }else if($statuskipas == '1'){
                              echo '<span style="width:100px"class="txkipas badge bg-green">HIDUP';
                            }
                          ?>
                            </span>
                          </th>
                          <td style="text-align:center">
                            <?php
                            if($statuskipas == '0'){
                              echo '<button style="width:100px" value="1" class="kipas btn btn-primary btn-md"><b>HIDUPKAN</b></button>';
                            }else if($statuskipas == '1'){
                              echo '<button style="width:100px" value="0" class="kipas btn btn-danger btn-md"><b>MATIKAN</b></button>';
                            }
                          ?>
                          </td>
                      </tr>
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

