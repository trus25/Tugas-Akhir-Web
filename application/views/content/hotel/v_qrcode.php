<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Check In
        <small>QRCode Check In</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Check In</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php if ($this->session->flashdata('confirm_failed')) { ?>
        <div class="form-group">
          <div class="alert alert-danger alert-primary alert-block">
      <?php echo $this->session->flashdata('confirm_failed') ?>
          </div>
      </div>
      <?php } ?>
      <?php if ($this->session->flashdata('confirm_success')) { ?>
      <div class="form-group">
        <div class="alert alert-success alert-primary alert-block">
        <?php echo $this->session->flashdata('confirm_success') ?>
        </div>
      </div>
      <?php } ?>
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Check In</h3>
            </div>  
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <div class="text-center" style="padding-top: 150px;">
                    <h1>Scan QRCode dibawah ini untuk Check-In</h1>
                    <img src="<?php echo config_item('base_url');?>uploads/qrcode/hotel<?php echo $this->session->userdata('idhotel');?>.png" alt="qrcode" style="padding-bottom: 160px;">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

