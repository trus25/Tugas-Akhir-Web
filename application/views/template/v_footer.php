<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
   <strong>Copyright &copy; 2019 <b>Monitor Hotel <?php echo $this->session->userdata('idhotel');?></b>.</strong> All rights reserved.
  </footer>

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo config_item('assets_bower');?>jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo config_item('assets_bower');?>jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo config_item('assets_bower');?>bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo config_item('assets_bower');?>raphael/raphael.min.js"></script>
<script src="<?php echo config_item('assets_bower');?>morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo config_item('assets_bower');?>jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo config_item('assets_plugins');?>jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo config_item('assets_plugins');?>jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo config_item('assets_bower');?>jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo config_item('assets_bower');?>moment/min/moment.min.js"></script>
<script src="<?php echo config_item('assets_bower');?>bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo config_item('assets_bower');?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo config_item('assets_plugins');?>bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo config_item('assets_bower');?>jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo config_item('assets_bower');?>fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo config_item('assets_dist');?>js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo config_item('assets_dist');?>js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo config_item('assets_dist');?>js/demo.js"></script>

<!-- DataTables -->
<script src="<?php echo config_item('assets_bower');?>datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo config_item('assets_bower');?>datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
</body>
</html>

<script>
    $(document).ready(function() {
        var kamar = $('#myroom').DataTable( {
            "sScrollX": "100%"
            // "columnDefs": [ {
            //     "searchable": true,
            //     "orderable": false,
            //     "targets": 0
            // } ],
            // "order": [[ 0, 'asc' ]]
        } );
        var dashboard = $('#dashboard').DataTable( {
            "sScrollX": "100%",
            // "columnDefs": [ {
            //     "searchable": true,
            //     "orderable": false,
            //     "targets": 0
            // } ],
            "order": [[ 6, 'desc' ]]
        } );

        var transaksi = $('#transaksi').DataTable( {
            "sScrollX": "100%",
            // "columnDefs": [ {
            //     "searchable": true,
            //     "orderable": false,
            //     "targets": 0
            // } ],
            "order": [[ 0, 'desc' ]]
        } );
 
    // t.on( 'order.dt search.dt', function () {
    //     t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
    //         cell.innerHTML = i+1;
    //     } );
    // } ).draw();
    } );

    $(document).ready(function() {
      var label = $('#idkamar');
      var idkamar = label.attr('idkamar');
        $('.pintu').click(function() {
          var statuspt = $(this).attr("value");
          var buttonpt = $(this);
          var textpt = $(".pintu b");
          var textstatuspt = $(".txpintu");
          jQuery.ajax({
                  url: "<?php echo site_url('Service/setPintu')?>/"+statuspt,
                  type: "POST",
                  data : {
                              idkamar : idkamar,
                          },
                  success:function(data){
                    if(statuspt=="1"){
                      buttonpt.removeClass("btn-primary").addClass("btn-danger");
                      buttonpt.attr("value", "0");
                      textpt.text("TUTUP");
                      textstatuspt.removeClass("bg-red").addClass("bg-green").text("BUKA");
                    }else if(statuspt=="0"){
                      buttonpt.removeClass("btn-danger").addClass("btn-primary");
                      buttonpt.attr("value", "1");
                      textpt.text("BUKA");
                      textstatuspt.removeClass("bg-green").addClass("bg-red").text("TUTUP");
                    }
                  }
                });
          
        });

        $('.lampu').click(function() {
            var statuslp = $(this).attr("value");
            var buttonlp = $(this);
            var textlp = $(".lampu b");
            var textstatuslp = $(".txlampu");
            jQuery.ajax({
                    url: "<?php echo site_url('Service/setLampu')?>/"+statuslp,
                    type: "POST",
                    data : {
                                idkamar : idkamar,
                            },
                    success:function(data){
                      if(statuslp=="1"){
                        buttonlp.removeClass("btn-primary").addClass("btn-danger");
                        buttonlp.attr("value", "0");
                        textlp.text("MATIKAN");
                        textstatuslp.removeClass("bg-red").addClass("bg-green").text("HIDUP");
                      }else if(statuslp=="0"){
                        buttonlp.removeClass("btn-danger").addClass("btn-primary");
                        buttonlp.attr("value", "1");
                        textlp.text("HIDUPKAN");
                        textstatuslp.removeClass("bg-green").addClass("bg-red").text("MATI");
                      }
                    }
                  });
          
        });

        $('.kipas').click(function() {
            var statuskp = $(this).attr("value");
            var buttonkp = $(this);
            var textkp = $(".kipas b");
            var textstatuskp = $(".txkipas");
            jQuery.ajax({
                    url: "<?php echo site_url('Service/setKipas')?>/"+statuskp,
                    type: "POST",
                    data : {
                                idkamar : idkamar,
                            },
                    success:function(data){
                      if(statuskp=="1"){
                        buttonkp.removeClass("btn-primary").addClass("btn-danger");
                        buttonkp.attr("value", "0");
                        textkp.text("MATIKAN");
                        textstatuskp.removeClass("bg-red").addClass("bg-green").text("HIDUP");
                      }else if(statuskp=="0"){
                        buttonkp.removeClass("btn-danger").addClass("btn-primary");
                        buttonkp.attr("value", "1");
                        textkp.text("HIDUPKAN");
                        textstatuskp.removeClass("bg-green").addClass("bg-red").text("MATI");
                      }
                    }
                  });
        });

        $('.lift').click(function() {
            var statuslf = $(this).attr("value");
            var idlf = $(this).attr("id");
            var buttonlf = $(this);
            jQuery.ajax({
                    url: "<?php echo site_url('Service/setLift')?>/"+statuslf,
                    type: "POST",
                    data : {
                                idlift : idlf,
                            },
                    success:function(data){
                      if(statuslf=="1"){
                        buttonlf.removeClass("btn-primary").addClass("btn-danger");
                        buttonlf.text("MATIKAN");
                        buttonlf.attr("value", "0");
                      }else if(statuslf=="0"){
                        buttonlf.removeClass("btn-danger").addClass("btn-primary");
                        buttonlf.text("AKTIFKAN");
                        buttonlf.attr("value", "1");
                      }
                      buttonlf.attr("style", "width:100px;font-weight:bold");
                    }
                  });
        });


        $('#tanggal, #durasi').change(function(){
          bothHaveValues()
        });

        function bothHaveValues() {
          if ($('#tanggal').val() != '' && $('#durasi').val() != '') {
            getAvailableRoom();
          }
        }

        function getAvailableRoom() {
          var checkin = $('#tanggal').val();
          var durasi = $('#durasi').val();
          jQuery.ajax({
                url: "<?php echo site_url('hotel/getAvailableRoom')?>",
                type: "POST",
                data : {
                            idhotel : <?php echo $this->session->userdata('idhotel');?>,
                            checkin : checkin,
                            durasi : durasi
                        },
                success:function(data){
                      var sel = $("#available");
                      sel.removeAttr('disabled');
                      sel.find('option').remove().end()
                      for(var i=0;i<data.kamartersedia.length;i++){
                        console.log(data.kamartersedia[i]['nomorkamar']);
                        sel.append('<option value="' + data.kamartersedia[i]['idkamar'] + '">' + data.kamartersedia[i]['nomorkamar'] + '</option>');
                      }
                      $('select').selectize({
                          sortField: 'text'
                      });
                }
              });
        }
        
    });
</script>