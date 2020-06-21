<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kamar
        <small>Data Kamar Hotel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
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
              <h3 class="box-title">Data Kamar Hotel</h3>
              <a href="<?php echo base_url('Myroom/add');?>"><button type="button" class="btn btn-md btn-primary" style="float: right;">Tambah Kamar</button></a>
            </div>  
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="myroom" class="table table-bordered table-striped table-hover" style="width: 100%">
                <thead>
                <tr>
                  <th class="col-md-1" style="text-align:center">Id</th>
                  <th class="col-md-1" style="text-align:center">Nomor Kamar</th>
                  <th class="col-md-1" style="text-align:center">DeviceId</th>
                  <th class="col-md-3" style="text-align:center">Check In</th>
                  <th class="col-md-3" style="text-align:center">Check Out</th>
                  <th class="col-md-2" style="text-align:center">Status</th>
                  <th class="col-md-1" style="text-align:center">Action</th>
                              
                </tr>
                </thead>
                <tbody>
                  <?php 
                  foreach($kamar as $km){
                  echo '<tr>
                        <th style="text-align:center">'.$km->k_id.'</th>
                        <th style="text-align:center">'.$km->k_nomor.'</th>
                        <th style="text-align:center">
                            <form action="'.base_url('Myroom/panel/'.$km->k_id.'').'" method="post">
                                  <button type="submit" name ="idkamar" value="'.$km->k_id.'" class="btn btn-primary">Room Control</button>
                            </form></th>
                        <th style="text-align:center">'.$km->m_checkin.'</th>
                        <th style="text-align:center">'.$km->m_checkout.'</th>
                        <th style="text-align:center">
                            <div class="col text-center">';
                        if($km->t_id==''){
                              echo 'Kamar Tersedia';
                          }else{
                            if($km->m_status=='0'){
                              echo 'BELUM CHECK IN';
                            }else if($km->m_status=='1'){
                              echo 'SUDAH CHECK IN';
                            }else if($km->m_status=='2'){
                              echo 'REQUEST CHECK OUT';
                          }  
                        }
                  echo '    </div>
                        </th>
                        <th style="text-align:center">
                            <div class="col text-center">';
                        if($km->t_id==''){
                              echo '';
                          }else{
                            if($km->m_status=='0'){
                              echo '<form action="'.base_url('Service/confirm').'" method="post">
                                          <button type="submit" name ="idtransaksi" value="'.$km->t_id.'" class="btn btn-success" style="width:200px">CHECK IN</button>
                                    </form>';
                            }else if($km->m_status=='1'){
                              echo '<form action="'.base_url('Service/checkout').'" method="post">
                                          <button type="submit" name ="idtransaksi" value="'.$km->t_id.'" class="btn btn-danger" style="width:200px">CHECK OUT</button>
                                    </form>';
                            }else if($km->m_status=='2'){
                              echo '<form action="'.base_url('Myroom/confirmchout').'" method="post">
                                          <button type="submit" name ="idtransaksi" value="'.$km->t_id.'" class="btn btn-primary" style="width:200px">Konfirmasi Checkout</button>
                                    </form>';
                          }  
                        }
                  echo '    </div>
                        </th>';
                  echo '</tr>'; 
                                   
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

