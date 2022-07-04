</div><!-- main-panel ends -->
</div><!-- page-body-wrapper ends -->
</div><!-- container-scroller -->

<script src="<?= base_url('assets/src/assets/vendors/datatables.net/jquery.dataTables.js'); ?>"></script>
<script src="<?= base_url('assets/src/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js'); ?>"></script>
<script src="<?= base_url('assets/src/assets/vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js'); ?>"></script>


<script src="<?= base_url('assets/src/assets/js/shared/off-canvas.js'); ?>"></script>
<script src="<?= base_url('assets/src/assets/js/shared/hoverable-collapse.js'); ?>"></script>
<script src="<?= base_url('assets/src/assets/js/shared/misc.js'); ?>"></script>
<script src="<?= base_url('assets/src/assets/js/shared/settings.js'); ?>"></script>
<script src="<?= base_url('assets/src/assets/js/shared/todolist.js'); ?>"></script>

<script src="<?= base_url('assets/js/jquery.slimscroll.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/select2.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/toastr.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.chained.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/file-upload.js'); ?>"></script>

<script type="text/javascript">
    <?php if ($this->session->flashdata('success')) { ?>
        toastr.success("<?= $this->session->flashdata('success'); ?>");
    <?php } else if ($this->session->flashdata('danger')) { ?>
        toastr.error("<?= $this->session->flashdata('danger'); ?>");
    <?php } else if ($this->session->flashdata('warning')) { ?>
        toastr.warning("<?= $this->session->flashdata('warning'); ?>");
    <?php } else if ($this->session->flashdata('info')) { ?>
        toastr.info("<?= $this->session->flashdata('info'); ?>");
    <?php } ?>

    $(document).ready(function() {
        $('.act-btn').addClass('shadow-sm animate__animated animate__bounce animate__repeat-3')
        // Datatable
        $("#data").DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_",
            }
        });
        $("#data1").DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_",
            }
        });
        $("#data2").DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_",
            }
        });
        $("#data3").DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_",
            }
        });
        $("#data4").DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_",
            }
        });
        $("#data5").DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_",
            }
        });
        $("#data6").DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_",
            }
        });
        $("#data7").DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_",
            }
        });
        $("#data8").DataTable({
            "oLanguage": {
                "sLengthMenu": "Show _MENU_",
            }
        });
        $("#jabatan").chained('#unit_kerja');

        $("#set_jabatan").chained("#set_unit_kerja");
        $("#set_pegawai").chained('#set_jabatan');

        $(".select2").select2();
        $(".file-upload").file_upload();
        $('[name="confirm"]').keyup(function(e) {

            e.preventDefault();

            var confirm = $('[name="confirm"]').val();
            var password = $('[name="password"]').val();

            if (confirm == '') {
                $('#notif-confirm').text('*Sesuaikan Dengan Password Diatas').css({
                    'color': 'red',
                    'font-weight': 'bold'
                });
                $("#button-disabled").attr('disabled', 'disabled');
            } else {

                if (confirm != password) {
                    $('#notif-confirm').text(' Tidak Sesuai Dengan Password Diatas').css('color', 'red');
                    $("#button-disabled").attr('disabled', 'disabled');

                } else {
                    $('#notif-confirm').text(' Telah Sesuai Dengan Password Diatas').css('color', 'green');
                    $("#button-disabled").removeAttr('disabled', 'disabled');

                }

            }
        });

    });
</script>

<?php if ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'login') { ?>
<?php } else { ?>
    <?php if ($this->session->userdata('level') == 0) { ?>
        <script type="text/javascript">
            $(document).ready(function() {
                setInterval(() => {
                    $.ajax({
                        url: "<?= base_url() ?>user/count_inbox_internal",
                        type: "POST",
                        dataType: "json",
                        data: {},
                        success: function(data) {
                            //alert(data.msg);
                            $("#count1").html(data.tot1);
                        }
                    });
                }, 2000);
                setInterval(() => {
                    $.ajax({
                        url: "<?= base_url() ?>user/count_inbox_eksternal",
                        type: "POST",
                        dataType: "json",
                        data: {},
                        success: function(data) {
                            //alert(data.msg);
                            $("#count2").html(data.tot2);
                        }
                    });
                }, 2000);
            });
        </script>
    <?php } ?>
<?php } ?>

</body>

</html>