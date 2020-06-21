<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi
        <small>Data Transaksi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Transaksi</li>
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
              <h3 class="box-title">Data Transaksi</h3>
              <a href="<?php echo base_url('Transaksi/add');?>"><button type="button" class="btn btn-md btn-primary" style="float: right;">Tambah Transaksi</button></a>
            </div>  
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="transaksi" class="table table-bordered table-striped table-hover" style="width: 100%">
                <thead>
                <tr>
                  <th class="col-md-1" style="text-align:center">Transaksi Id</th>
                  <th class="col-md-1" style="text-align:center">Nomor Kamar</th>
                  <th class="col-md-1" style="text-align:center">Nama User</th>
                  <th class="col-md-2" style="text-align:center">Tanggal Pesan</th>
                  <th class="col-md-3" style="text-align:center">Check In</th>
                  <th class="col-md-3" style="text-align:center">Check Out</th>
                              
                </tr>
                </thead>
                <tbody>
                  <?php 
                  foreach($transaksi as $tr){
                  echo '<tr>
                          <th style="text-align:center">'.$tr->t_id.'</th>
                          <th style="text-align:center">'.$tr->k_nomor.'</th>
                          <th style="text-align:center">'.$tr->u_username.'</th>
                          <th style="text-align:center">'.$tr->t_tanggal.'</th>
                          <th style="text-align:center">'.$tr->m_checkin.'</th>
                          <th style="text-align:center">'.$tr->m_checkout.'</th>
                        </tr>';
                  }
                ?>
                </tbody>
              </table>
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

