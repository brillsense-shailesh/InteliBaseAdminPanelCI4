<!-- -----------main page start----------- -->
<div class="offcanvas offcanvas-end  vendor-offcanvas" tabindex="-1" id="right_floating_div">
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
                <a href="<?= base_url(route_to('state_create_update_page')) ?>">
                    <button class="btn add_form_btn"><i class="bx bx-plus me-2"></i>Add State</button>
                </a>
            </div>
            <div class="table-responsive">
                <table id="state_table" class="table table-striped table-bordered dt-responsive nowrap table-nowrap align-middle"></table>
            </div>
        </div>
    </div>
</div>

<script>
    var DeleteApiUrl = "<?= base_url(route_to('state_delete_api')) ?>"

function state_delete(state_id) {
    deleteRow({
            "state_id": state_id
        }).then((response) => {
            fetchData()
        })
        .catch((error) => {
            console.error("Deletion failed or cancelled:", error);
        });
}

function state_view(state_id) {
    $.ajax({
        type: "post",
        url: "<?= base_url(route_to('state_view_component')) ?>",
        data: {
            state_id: state_id
        },
        success: function(response) {
            $("#right_floating_div").html("");
            $("#right_floating_div").html(response);
        }
    });
}
    function successCallback(response) {
        if (response.status == 200 || response.status == 201) {
            $(".offcanvas button[data-bs-dismiss='offcanvas']").click();
            fetchTableData();
        }
    }

    function errorCallback(response) {
        console.log(response);
    }

    function successDataTableCallbackFunction(response) {
        var columns = [{
                title: "ID",
                data: "state_id",
                visible: true
            },
            {
                title: "state Name",
                data: "state_name"
            },
            {
                title: "Short Name",
                data: "short_name"
            },
            {
                title: "State Code",
                data: "state_code"
            },
            {
                title: "Country Name",
                data: "country_name"
            },
            {
                "title": "Actions",
                "data": null,
                "render": function(data, type, row) {
                    return `
                            
                            <button class="text-white btn btn-sm btn-info" onclick="state_view(${row.state_id})" data-bs-toggle="offcanvas" data-bs-target="#right_floating_div" aria-controls="right_floating_div">
                                <i class="fa fa-eye"></i>
                            </button>
                            
                            <a href="<?= base_url(route_to('state_create_update_page')) ?>/${row.state_id}" class="text-white btn btn-sm btn-success">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <button class="text-white btn btn-sm btn-danger" onclick="state_delete(${row.state_id})">
                                <i class="bx bx-trash-alt"></i>
                            </button>
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
            'state_table', // table_id
            "<?= base_url(route_to('state_list_api')) ?>", // url
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