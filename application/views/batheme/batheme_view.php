<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Learn PHP CodeIgniter Framework with AJAX and Bootstrap</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<div class="container">
    <h1>Gestion de batheme</h1>
    </center>
    <h3>Batheme</h3>
    <br />
    <button class="btn btn-success" onclick="add_book()"><i class="glyphicon glyphicon-plus"></i> Add Book</button>
    <br />
    <br />
    <table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Batheme ID</th>
            <th>Date batheme</th>
            <th>Date close</th>
            <th>Description</th>

            <th style="width:125px;">Action
                </p></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($bathemes as $batheme){?>
            <tr>
                <td><?php echo $batheme->bat_id;?></td>
                <td><?php echo $batheme->date_bat;?></td>
                <td><?php echo $batheme->date_close;?></td>
                <td><?php echo $batheme->description;?></td>
                <td>
                    <button class="btn btn-warning" onclick="edit_book(<?php echo $batheme->bat_id;;?>)"><i class="glyphicon glyphicon-pencil"></i></button>
                    <button class="btn btn-danger" onclick="delete_book(<?php echo $batheme->bat_id;;?>)"><i class="glyphicon glyphicon-remove"></i></button>


                </td>
            </tr>
        <?php }?>



        </tbody>

        <tfoot>
        <tr>
            <th>Batheme ID</th>
            <th>Date batheme</th>
            <th>Date close</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>

</div>

<script src="<?php echo base_url('assets/jquery/jquery-3.1.0.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>


<script type="text/javascript">
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
    var save_method; //for save method string
    var table;


    function add_book()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('#modal_form').modal('show'); // show bootstrap modal
        //$('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }

    function edit_book(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('batheme/ajax_edit/')?>/" +id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="bat_id"]').val(data.bat_id);
                $('[name="date_bat"]').val(data.date_bat);
                $('[name="date_close"]').val(data.date_close);
                $('[name="description"]').val(data.description);

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Book'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Recuperation de donnees corrompu');
            }
        });
    }



    function save()
    {
        var url;
        if(save_method == 'add')
        {
            url = "<?php echo site_url('batheme/batheme_add')?>";
        }
        else
        {
            url = "<?php echo site_url('batheme/batheme_update')?>";
        }

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                //if success close modal and reload ajax table
                $('#modal_form').modal('hide');
                location.reload();// for reload a page
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }

    function delete_book(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data from database
            $.ajax({
                url : "<?php echo site_url('batheme/batheme_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Une erreure se produit');
                }
            });

        }
    }

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Batheme formulaire</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="bat_id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Date batheme</label>
                            <div class="col-md-9">
                                <input name="date_bat" placeholder="Book ISBN" class="form-control" type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date fermeture</label>
                            <div class="col-md-9">
                                <input name="date_close" placeholder="date_close" class="form-control" type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                                <input name="description" placeholder="Book Author" class="form-control" type="text">

                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

</body>
</html>
