<!-- -----------main page start----------- -->
<div class="offcanvas offcanvas-end  vendor-offcanvas" style="overflow: scroll; width:850px!important" tabindex="-1" id="right_floating_div">
</div>

<div class="row new_table_div col-md-12">
    <div class="card">
        <div class="card-body p-2">
            <div class="d-flex justify-content-end align-items-center mb-2">
                <a href="<?= base_url(route_to('default_dashboard_page')) ?>"><i class="fas fa-home home_icn me-3"></i></a>
                <img onclick="fetchTableData()" src="<?php echo base_url('AdminPanelNew/assets/images/refresh.png') ?>" height="20" class="me-3">
                <a href="<?= @$_previous_path ?>">
                    <button class="btn export_btn me-3" type="button"><i class="fas fa-backward"></i></button>
                </a>
                <?php if (check_menu_access('DELIVERY_TERMS', 'create')): ?>
                    <button onclick="delivery_term_create_update()" class="btn add_form_btn" data-bs-toggle="offcanvas" data-bs-target="#right_floating_div" aria-controls="right_floating_div"><i class="bx bx-plus me-2"></i>Add Delivery Terms</button>
                <?php endif; ?>
            </div>
            <div class="table-responsive">
                <table id="delivery_term_table" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle"></table>
            </div>
        </div>
    </div>
</div>

<script>
    var datatable_export = '<?= (check_menu_access('DELIVERY_TERMS', 'export')) ?>';
    var datatable_print = '<?= (check_menu_access('DELIVERY_TERMS', 'print')) ?>';
    var print_allowed = '<?= (check_menu_access('DELIVERY_TERMS', 'print')) ?>';
    var DeleteApiUrl = "<?= base_url(route_to('delivery_terms_delete_api')) ?>";

    function delivery_term_delete(delivery_term_id) {
        deleteRow({
                "delivery_term_id": delivery_term_id
            }).then((response) => {
                fetchTableData()
            })
            .catch((error) => {
                console.error("Deletion failed or cancelled:", error);
            });
    }

    function delivery_term_create_update(delivery_term_id = '') {
        var data = {};
        if (delivery_term_id != '') {
            data.delivery_term_id = delivery_term_id
        }
        $.ajax({
            type: "post",
            url: "<?= base_url(route_to('delivery_terms_create_update_component')) ?>",
            data: data,
            success: function(response) {
                $("#right_floating_div").html("");
                $("#right_floating_div").html(response);
            }
        });
    }

    function delivery_termFormSuccessCallback(response) {
        if (response.status == 200 || response.status == 201) {
            $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
            fetchTableData();
        }
    }

    function delivery_termFormErrorCallback(response) {
        console.log(response);
    }

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "ID",
                data: "delivery_term_id",
                visible: true
            },
            {
                title: "Delivery Term Code",
                data: "delivery_term_code",
                visible: true
            },
            {
                title: "Delivery Term",
                data: "delivery_term_name",
                visible: true
            },
            {
                title: "Description",
                data: "delivery_term_description",
                visible: true
            },
            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
                            <?php if (check_menu_access('DELIVERY_TERMS', 'edit')): ?>
                                <button type="button" onclick="delivery_term_create_update('${row.delivery_term_id}')" data-bs-toggle="offcanvas" data-bs-target="#right_floating_div" aria-controls="right_floating_div" class="text-white btn btn-sm btn-success">
                                    <i class="bx bx-edit-alt"></i>
                                </button>
                            <?php endif; ?>
                            <?php if (check_menu_access('DELIVERY_TERMS', 'delete')): ?>
                                <button class="text-white btn btn-sm btn-danger" onclick="delivery_term_delete(${row.delivery_term_id})">
                                    <i class="bx bx-trash-alt"></i>
                                </button>
                            <?php endif; ?>
                        `;
                }
            }
        ];
        if (response.status == 200) {
            return {
                "status": response.status,
                "columns": columns,
                "data": JSON.parse(response.data)
            };
        } else {
            return {
                "status": response.status,
                "columns": columns,
                "data": {}
            };
        }
    }

    function fetchTableData(parameter = {}) {
        parameter._autojoin = 'F';
        parameter._select = '*';
        DataTableInitialized(
            'delivery_term_table', // table_id
            "<?= base_url(route_to('delivery_terms_list_api')) ?>", // url
            'POST', // method
            parameter, // parameter
            successDataTableCallbackFunction // dataTableSuccessCallBack
        );
    }
    $(document).ready(function() {
        fetchTableData();
    });
</script>
<!-- --------------main page end----------- -->