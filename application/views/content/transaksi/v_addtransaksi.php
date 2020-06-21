<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi
        <small>Form Tambah Transaksi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Transaksi</li>
        <li class="active">Form Tambah Pengguna</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <?php if ($this->session->flashdata('transaksi_gagal')) { ?>
    <div class="form-group">
      <div class="alert alert-danger alert-primary alert-block">
      <?php echo $this->session->flashdata('transaksi_gagal') ?>
      </div>
    </div>
    <?php } ?>
    <?php if ($this->session->flashdata('transaksi_sukses')) { ?>
    <div class="form-group">
      <div class="alert alert-success alert-primary alert-block">
      <?php echo $this->session->flashdata('transaksi_sukses') ?>
      </div>
    </div>
    <?php } ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Form Tambah Pengguna</h3>
               <a href="<?php echo base_url('pengguna');?>"><button type="button" class="btn btn-md btn-primary" style="float: right;">Kembali</button></a>
                <!-- Modal Dokumen -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" method="POST" action="<?php echo base_url('transaksi/add') ?>">
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <input type="hidden" class="form-control bradius" name="idhotel" value="<?php echo $this->session->userdata('idhotel');?>">
                    </div>
                    <div class="form-group">
                      <label>Userame</label>
                      <input type="text" class="form-control bradius" name="username" placeholder="Username" required="">
                    </div>
                    <div class="form-group">
                      <label>Nomor HP</label>
                      <input type="password" class="form-control bradius" name="nohp" placeholder="nomor hp" required="">
                    </div>
                    <div class="form-group">
                      <label>Tanggal</label>
                      <input type="date" id="tanggal" class="form-control bradius" name="checkin" required="">
                    </div>
                    <div class="form-group">
                      <label>Durasi</label>
                      <input type="text" id="durasi" class="form-control bradius" name="durasi" placeholder="durasi" required="">
                    </div>
                    <div class="form-group">
                      <label>Nomor kamar</label>
                      <select id="available" disabled class="form-control bradius" name="idkamar" required="">
                      </select>
                    </div>
                    <br>
                    <div class="form-group">
                      <input type="Submit" class="btn btn-primary mt-10 btn-md" style="float:Right;" value="Submit" />

                    </div>
                  </div>
                  <div class="col-md-4"></div>
                </div>
              </form>
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
