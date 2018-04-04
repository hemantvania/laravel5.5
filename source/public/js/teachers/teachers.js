jQuery(function () {
    /**
     * Showing loader for the first time for 1000
     */
    showloader();

    /**
     * Toggle Loader after 1000
     *
     */
    setTimeout(function(){
        showloader();
    }, 1000);

    /**
     *  Extending jQuery datatable error
     *
     */
    $.fn.dataTable.ext.errMode = 'none';

    /**
     *  Initiate jQuery Data Table Object
     *
     */
    var MaterialTable = jQuery('#materiallist').on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
    } ).DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        ajax: materilurl,
        columns: [
            {data: 'action' },
            {data: 'materialName', name: 'materials.materialName'},
            {data: 'description', name: 'materials.description'},
            {data: 'fullname', name: 'users.id'},
            {data: 'materialType', name: 'materials.materialType'},
            {data: 'isDownloadable', name: 'materials.isDownloadable'},
            {data: 'created_at', name:'materials.created_at'},
            {data: 'deloption', name:'materials.deloption'},
        ],
        'columnDefs': [
            {
                'targets': 0,
                'width': '50px',
                'searchable': false,
                'orderable': false,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_mchk);
                }
            },
			{
				'targets': 1,
                'width': '200px',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_mname);
                },
				'render': function (data, type, full, meta){
					return '<a href="'+full.viewlink+'" target="_blank">'+data+'</a>';
				}
			},
            {
                'targets': 2,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_mdesc);
                },
                'width': '250px',
            },
            {
                'targets': 3,
                'width': '130px',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_mowner);
                }

            },
            {
                'targets': 4,
                'width': '50px',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_type);
                }
            },
			{
				'targets': 5,
                'width': '100px',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_mfrom);
                },
				'render': function (data, type, full, meta){
                    var valid;
                    var invalid;
				    if(data == '1'){
				        valid = "selected='selected'";
                        invalid = "";
                    } else {

                        invalid = "selected='selected'";
                        valid = "";
                    }

                    return '<select class="custom-dropdown" data-id="'+full.id+'" name="isDownloadable" data-url="'+full.statusurl+'"> <option value="1" '+valid+'>'+mdownlodable+'</option><option value="2" '+ invalid +'>'+monline+'</option></select>';
				}
			},{
                'targets': 6,
                'width': '130px',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_mloaded);
                }
            },{
                'targets': 7,
                'width': '80px',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_deloption);
                },
                'render': function (data, type, full, meta){
                    if(data === 'true') {
                        return '<div class="btn-group"><a href="javascript:void(0);" data-id="'+full.id+'" class="remove-materilas btn btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" ></i ></a></div>';
                    } else {
                        return '';
                    }
                }
            }
		],
        'order': [[1, 'asc']]
    });
	
	MaterialTable.on( 'draw.dt', function () {
		jQuery(".custom-dropdown").selectpicker();

        /**
         * remove materials from uploaded by teacher only
         */
        jQuery('.remove-materilas').on('click',function(){
            showloader();
            var materialid = jQuery(this).attr('data-id');
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: materialdelurl,
                type: 'POST',
                data: { 'materialid':materialid} ,
                success: function (data) {
                    showloader();
                    if(data.status === true){
                        showmessage(data.message);
                    } else {
                        showerrormessage(data.message);
                    }
                    MaterialTable.ajax.reload();
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                    jQuery(".loadmoreimg").hide();
                }
            });

        });
	} );
	
    /**
     *  Check All Event
     *
     */
    jQuery('#material-select-all').on('click', function(){
        // Get all rows with search applied
        var rows = MaterialTable.rows({ 'search': 'applied' }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
    });



    /**
     *  Handle click on checkbox to set state of "Select all" control
     *
     */
    jQuery('#materiallist tbody').on('change', 'input[type="checkbox"]', function(){
        // If checkbox is not checked
        if(!this.checked){
            var el = jQuery('#material-select-all').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if(el && el.checked && ('indeterminate' in el)){
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    });

    /**
     *  Assign Materilas to class via ajax handler
     *
     */
    jQuery("#assign_materials").change(function(){
        showloader();
        var selectedClass = jQuery(this).val();
        var assignMurl = jQuery(this).attr('data-url');

        if(selectedClass !== '0'){
            var materialdata = MaterialTable.$('input[type="checkbox"]').serialize();

            if(materialdata !== ''){
                materialdata =  materialdata+'&classid='+selectedClass;
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: assignMurl,
                    type: 'POST',
                    data: materialdata ,
                    success: function (data) {
                        showloader();
                        if(data.status === true){
                            showmessage(data.message);
                        } else {
                            showerrormessage(data.message);
                        }
                        MaterialTable.ajax.reload();
                        refreshAssignClassesBox('assign_materials');
                    },
                    error: function (data) {
                        showloader();
                        if (data.status === false) {
                            showerrormessage(data.message);
                        }
                        jQuery(".loadmoreimg").hide();
                    }
                });
            } else {
                showloader();
                jQuery("#assign_materials_to_calss").modal('show');
                refreshAssignClassesBox('assign_materials');
            }
        } else {
            showloader();
            refreshAssignClassesBox('assign_materials');
            jQuery("#assign_class_material").modal('show');
        }
    });

    /**
     * Clear Search
     *
     */
    jQuery('#btn_clear').click(function () {
        MaterialTable
            .search('')
            .columns().search('')
            .draw();
    })

    /**
     * Apply Search Box Event
     *
     */
    jQuery(".btn-search").click(function () {
        var typeval = jQuery('#type_filter').val();
        var owner   = jQuery('#owner_filter').val();
        MaterialTable.column(2).search(
            owner
        ).draw();

        MaterialTable.column(3).search(
            typeval
        ).draw();
        jQuery('.dropdown-custom').hide();
    });

    /**
     * Apply Global Search box
     *
     */
    jQuery('#global_search').on('keyup click', function () {
        MaterialTable.column(1).search(
            jQuery('#global_search').val()
        ).draw();
    });



    /**
     * Student management tab click event handler
     *
     */
    jQuery("#students-tab").click(function () {
        if (!$.fn.DataTable.isDataTable('#studentlist')) {
            showloader();

            showloader();
        }
    });

    /**
     * Show Desk Click Event Handler
     *
     */
    jQuery("#btnshowdesk").click(function(){
        showloader();
        jQuery("#students-desk-list").html('');
        var showurl     = jQuery("#show_class option:selected").attr('data-url');
        var showClassid = jQuery("#show_class option:selected").val();
        if(showClassid !== '0'){
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: showurl,
                type: 'POST',
                data: { showid: showClassid  },
                success: function (data) {
                    //showmessage(data.message);
                    jQuery("#students-desk-list").html(data)
                    showloader();
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                    jQuery(".loadmoreimg").hide();
                }
            });
        } else {
            showloader();
            showerrormessage(edeskerrorMsg);
        }

    });

    /**
     * Change Material Type
     *
     */
    jQuery("#materialType").change(function () {
        if(this.value == "Link"){
            jQuery("#uploadcontent").val('');
            jQuery("#upload-contents").hide();
            jQuery("#upload-externalurl").show();
        } else {
            jQuery("#thirdPartyLink").val('');
            jQuery("#upload-contents").show();
            jQuery("#upload-externalurl").hide();
        }
    });

    /**
     *  Download materials via ajax handler
     *
     */
	jQuery("#download-materials-dashboard").click(function(){
        showloader();
			var selected = [];
			jQuery("input:checkbox[name='materialsids[]']:checked").each(function() {
			   selected.push(jQuery(this).val());
			});
                var token = jQuery('input:hidden[name=_token]').val();

                var downloadUrl = jQuery(this).attr('data-url');

                jQuery.ajax({
                    type: "POST",
                    url: downloadUrl,
                    beforeSend: function (xhr) {
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {'contents': selected},
                    success: function (data) {
                        showloader();
                        if (data.status) {
                            location.href = data.filename;
                            showmessage(data.message);
                        } else {
                            showerrormessage(data.message);
                        }
                        //console.log(data);
                    },
                    error: function (data) {
                        showloader();
                        showerrormessage(data.message);
                    }
                });
	});

    /**
     * Handle click on change dropdown for change matreial isdownloadable to online wiseversa
     */
    jQuery("#changeStauts").unbind('change');

    jQuery('#materiallist tbody').on('change','.custom-dropdown', function(){
        var selectedOp = this.value;
        var selectedid = jQuery(this).attr('data-id');
        var statusurl  = jQuery(this).attr('data-url');
        showloader();
        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            url: statusurl,
            type: 'POST',
            data: {
                   'materialid': selectedid, 'status':selectedOp
            },
            success: function( data ) {
                if ( data.status == true ) {
                    if(data.status === true){
                        showmessage(data.message);
                        MaterialTable.ajax.reload();
                    } else {
                        showerrormessage(data.message);
                    }
                } else {
                    showerrormessage(data.message);
                }
                showloader();
            },
            error: function( data ) {
                if (data.status === false) {
                    showerrormessage(data.message);
                }
                showloader();
            }
        });

        return false;
    });

    /**
     * For Students list jQuery datatables
     *
     */
    var studentlist = jQuery('#studentlist').on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
    } ).DataTable({
        processing: true,
        serverSide: true,
        ajax: studentsurl,
        columns: [
            {
                data: 'assign', name: 'assign'
            },
            {data: 'first_name', name: 'users.first_name'},
            {data: 'last_name', name: 'users.last_name'},
            {data: 'email', name: 'users.email'},
            {data: 'phone', name: 'user_metas.phone'},
            {data: 'addressline1', name: 'user_metas.addressline1'},
            {data: 'ClassName', name: 'classes.ClassName'}
            /** removed crud as per client's instructions

			
			,
            {data: 'action', name: 'action'} */
        ],
        'columnDefs': [
            {
            'targets': 0,
            'searchable': false,
            'orderable': false,
            'className': 'dt-body-center',
            'render': function (data, type, full, meta){
                return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '" id="test_'+data+'"><label for="test_'+data+'"></label>';
            },

            },
            {
                'targets': 1,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_fname);
                },
            },
            {
                'targets': 2,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_lname);
                },
            },
            {
                'targets': 3,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr({'data-label':lbl_email, 'title': rowData.email});
                },
                render: function ( data, type, row ) {
                    return getLimitedString(data,15);
                }
            },
            {
                'targets': 4,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_phone);
                },
            },
            {
                'targets': 5,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_addr);
                },
            },
		
		/** removed crud as per client's instructions
		
		,
            {
                'targets': 6,
                'searchable': false,
                'orderable': false,
            }
			**/
        ],
        'order': [[1, 'asc']]

    });

    /**
     * Select all checkbox handler for students grid
     *
     */
    jQuery('#student-select-all').on('click', function(){
        // Get all rows with search applied
        var rows = studentlist.rows({ 'search': 'applied' }).nodes();
        // Check/uncheck checkboxes for all rows in the table
        jQuery('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    /**
     * Handle click on checkbox to set state of "Select all" control
     *
     */
    jQuery('#studentlist tbody').on('change', 'input[type="checkbox"]', function(){
        // If checkbox is not checked
        if(!this.checked){
            var el = $('#student-select-all').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if(el && el.checked && ('indeterminate' in el)){
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    });

    /**
     * Assign Student to seleceted Class
     *
     */
    jQuery("#studentclass").change(function(){
        showloader();
        var selectedClass = jQuery(this).val();
        var assignurl = jQuery(this).attr('data-url');
        if(selectedClass !== '0'){
            var studentdata = studentlist.$('input[type="checkbox"]').serialize();
            if(studentdata !== ''){
                studentdata =  studentdata+'&classid='+selectedClass;
                jQuery.ajax({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    url: assignurl,
                    type: 'POST',
                    data: studentdata ,
                    success: function (data) {
                        showloader();
                        if(data.status === true){
                            showmessage(data.message);
                        } else {
                            showerrormessage(data.message);
                        }
                        studentlist.ajax.reload();
                        refreshAssignClassesBox('studentclass');
                    },
                    error: function (data) {
                        showloader();
                        if (data.status === false) {
                            showerrormessage(data.message);
                        }
                        jQuery(".loadmoreimg").hide();
                    }
                });
            } else {
                showloader();
                refreshAssignClassesBox('studentclass');
                jQuery("#assign_class_select_student").modal('show');
            }
        } else {
            showloader();
            refreshAssignClassesBox('studentclass');
            jQuery("#assign_class").modal('show');
        }
    });

    /**
     * Assign global_search_user
     *
     */

    jQuery('#global_search_user').on('keyup click', function () {
        studentlist.search(
            jQuery('#global_search_user').val()
        ).draw();
    });

    /**
     * On Draw Event of Student data tables
     *
     */
    studentlist.on('draw', function () {
        /**
         * Function is use for delete records
         *
         */
        jQuery(".remove-adminusers").unbind().click(function (e) {
            e.preventDefault();
            var userId = jQuery(this).attr("data-index");
            var delurl = jQuery(this).attr("data-url");
            jQuery('#confirmDelete').attr('data-id', userId);
            jQuery('#confirmDelete').attr('data-url', delurl);
            jQuery('#confirmDelete').modal('show');
        });

        /**
         * Add New Student
         *
         */
        jQuery("#add_new").click(function () {
            showloader();
            var studenaddurl = jQuery(this).attr('data-url');
            jQuery("#add_edit_form").attr('data-url', studenaddurl);
            jQuery("#student_from").attr('action', studenaddurl);
            jQuery.ajax({
                url: studenaddurl,
                type: 'GET',
                success: function (data) {
                    showloader();
                    jQuery("#add_edit_form").find('modal-body').html(data)
                    // console.log(data);
                    jQuery("#form_data").html('');
                    jQuery("#form_data").html(data);
                    jQuery("#add_edit_form").modal('show');
                    jQuery('.selectpicker').selectpicker();
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                    jQuery(".loadmoreimg").hide();
                }
            });
        });

        /**
         * Edit Get Student Records Based On Click Event
         *
         */
        jQuery(".edit_student").click(function (e) {
            showloader();
            var studenurl = jQuery(this).attr('data-url');
            jQuery("#add_edit_form").attr('data-url', studenurl);
            jQuery("#student_from").attr('action', studenurl);
            jQuery.ajax({
                url: studenurl,
                type: 'GET',
                success: function (data) {
                    showloader();
                    jQuery("#add_edit_form").find('modal-body').html(data)
                    // console.log(data);
                    jQuery("#form_data").html('');
                    jQuery("#form_data").html(data);
                    jQuery("#add_edit_form").modal('show');
                    jQuery('.selectpicker').selectpicker();
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                    jQuery(".loadmoreimg").hide();
                }
            });

        })
        /**
         * Add/Edit Form Submit Event Handler
         *
         */
        jQuery("#savestudent").click(function () {

            showloader();
            var formdata = jQuery("#student_from").serialize();
            var udpateurl = jQuery("#add_edit_form").attr('data-url');
            jQuery.ajax({
                url: udpateurl,
                type: 'POST',
                data: formdata,
                success: function (data) {
                    showloader();
                    if (data.sucess != '') {
                        jQuery("#add_edit_form").modal('hide');
                        showmessage(data.message);
                        studentlist.ajax.reload();
                    } else if (data.error) {
                        jQuery("#add_edit_form").modal('hide');
                        showerrormessage(data.message);
                        studentlist.ajax.reload();
                    }
                }
            }).fail(function($xhr) {
                showloader();
                var data = $xhr.responseJSON;
                if(data.name){
                    showFormVadlidationMessage('first_name',data.name[0]);
                }
                if(data.last_name){
                    showFormVadlidationMessage('last_name',data.last_name[0]);
                }
                if(data.email){
                    showFormVadlidationMessage('email',data.email[0]);
                }
                if(data.password){
                    showFormVadlidationMessage('password',data.password[0]);
                }
                if(data.phone){
                    showFormVadlidationMessage('phone',data.phone[0]);
                }
                if(data.addressline1){
                    showFormVadlidationMessage('addressline1',data.addressline1[0]);
                }
                if(data.city){
                    showFormVadlidationMessage('city',data.city[0]);
                }
                if(data.zip){
                    showFormVadlidationMessage('postal_code',data.zip[0]);
                }
            });
        });
        /**
         * Fire Ajax Call on click "Yes" button
         *
         */
        jQuery("#btnYes").unbind().click(function (e) {
            // handle deletion here
            var userId = jQuery('#confirmDelete').attr('data-id');
            var delurlf = jQuery('#confirmDelete').attr('data-url');
            showloader();
            jQuery('#confirmDelete').modal('hide');
            jQuery(".alert-success").remove();
            jQuery(".alert-danger").remove();
            jQuery.ajax({
                url: delurlf,
                type: 'GET',
                data: userId,
                success: function (data) {
                    showloader();
                    if (data.status == true) {
                        showmessage(data.message);
                    } else {
                        showerrormessage(data.message);
                    }
                    studentlist.ajax.reload();
                    jQuery(".loadmoreimg").hide();
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                    jQuery(".loadmoreimg").hide();
                }
            });
        });


        /**
         * Function is use for restore deleted records
         *
         */
        jQuery(".restore-adminusers").on('click', function (e) {
            jQuery(".loadmoreimg").show();
            var userId = jQuery(this).attr("data-index");
            var restore_url = jQuery(this).attr('data-url');
            showloader();
            jQuery(".alert-success").remove();
            jQuery(".alert-danger").remove();
            jQuery.ajax({
                url: restore_url,
                type: 'GET',
                data: userId,
                success: function (data) {
                    showloader();
                    if (data.status == true) {
                        showmessage(data.message);
                    } else {
                        showerrormessage(data.message);
                    }
                    studentlist.ajax.reload();
                    jQuery(".loadmoreimg").hide();
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                    jQuery(".loadmoreimg").hide();
                }
            });

            return false;
        });
    });



    /**
     * For Notification list jQuery datatables
     *
     */
    notificationlist = jQuery('#notificationlist').on( 'error.dt', function ( e, settings, techNote, message ) {
        console.log( 'An error has been reported by DataTables: ', message );
    } ).DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        ajax: notificationurl,
        columns: [
            {data: 'name', name: 'name'},
            {data: 'className', name: 'className'},
            {data: 'created_at', name: 'created_at'},

        ],
        'columnDefs': [
            {
                'targets': 0,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_studentName);
                },
            },
            {
                'targets': 1,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_className);
                },
            },
            {
                'targets': 2,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).attr('data-label',lbl_date);
                },
            },
        ],
        'order': [[1, 'asc']]

    });

    /**
     * Assign global_search_student
     *
     */

    jQuery('#global_search_student').on('keyup click', function () {
        notificationlist.search(
            jQuery('#global_search_student').val()
        ).draw();
    });

    /**
     * Initiate the chat with message box with ajax call which checking for thred
     */
    jQuery("#startchat").click(function() {

            showloader();

            var studentsids = '';

            jQuery('#online_students input[type="checkbox"]').each(function (index, value) {
                if (jQuery(this).is(':checked')) {
                    if (studentsids === '') {
                        studentsids = jQuery(value).val();
                    } else {
                        studentsids = studentsids + "," + jQuery(value).val();
                    }
                }
            });

            /**
             * Ajax Call For Thread
             */
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: threadurl,
                type: 'POST',
                data: {
                    'studentsids': studentsids
                },
                success: function (data) {
                    showloader();
                    if(data.threadid != ''){
                        loadChatBox(data, data.threadid, '', '', false)
                    } else {
                        showerrormessage(data.message);
                    }
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                }
            });
    });

    /**
     * Remnove User from the chat. Status Pending from now
     */
    jQuery( document ).on( "click", ".close-list-btn", function() {
        jQuery(this).parent().parent().remove();
        /**
         * Ajax call for removing user from the chat
         */
    });

    /**
     * Click Event Handler of send message button
     */
    jQuery(document).on("click",".send_message",function(){

            var objText     = jQuery(this).parent().parent().find('textarea');
            var objMessage  = jQuery(this).parent().parent().parent().find('.message_section');
            var threadid    = jQuery(this).parent().parent().parent().find('.thread_id').val();
            var message     = objText.val();
            /**
             * Ajax Call For Thread
             */
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: messageurl,
                type: 'POST',
                data: {
                    'threadid': threadid,
                    'message': message
                },
                success: function (data) {
                    //console.log(data);
                    objText.val('');
                },
                error: function (data) {
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                }
            });
    });

    /**
     * View Message Click Event Handler
     */
    jQuery(document).on('click','.view_message',function(){

            var treadid    = jQuery(this).parent().attr('thread-id');
            var senderid   = jQuery(this).parent().attr('sender-id');
            var sendername = jQuery(this).parent().attr('sendername');

            /**
             * Ajax Call For Thread
             */
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: threadurl,
                type: 'POST',
                data: {
                    'studentsids': senderid,
                    'threadid': treadid
                },
                success: function (data) {
                    loadChatBox(data, treadid, senderid, sendername, true);
                },
                error: function (data) {
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                }
            });
            jQuery(this).parent().toggleClass('active');

    });

    /**
     * One to one Communication between teacher and students
     */
    jQuery(document).on("click",".openchat",function(e){

            var studentid   = jQuery(this).attr('data-id');
            var studentname = jQuery(this).attr('data-sender');

            showloader();
            /**
             * Ajax Call For Thread
             */
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: threadurl,
                type: 'POST',
                data: {
                    'studentsids': studentid
                },
                success: function (data) {
                    showloader();
                    if(data.threadid != ''){
                        loadChatBox(data, data.threadid, studentid, studentname, true);
                    } else {
                        showerrormessage(data.message);
                    }
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                }
            });

    });

    /**
     * Enter Key press event handler
     */

    jQuery(document).on("keypress","textarea",function(e){
        if (e.which == '13') {
            var messagesis = jQuery(this).val();
            var paretclass = jQuery(this).parent();
            if(messagesis != "")
            {
                jQuery(paretclass).find('.send_message').trigger('click');
                e.preventDefault();
            }
        }
    });


    /**
     * Shreen Share Event Handler
     */
    jQuery("#sharescreen").on('click',function(){

            showloader();
            var shareids = '';
            jQuery('#share_screen_students input[type="checkbox"]').each(function (index, value) {
                if (jQuery(this).is(':checked')) {
                    if (shareids === '') {
                        shareids = jQuery(value).val();
                    } else {
                        shareids = shareids + "," + jQuery(value).val();
                    }
                }
            });

            /**
             * Ajax Call For Thread
             */
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: shareurl,
                type: 'POST',
                data: {
                    'shareids': shareids,
                    'viwer':'true'
                },
                success: function (data) {
                    showloader();
                    if(data.status === false){
                        showerrormessage(data.message);
                    } else {
                        if (data.presenterLink != '') {
                            var sharingWindow = window.open(data.presenterLink, '_blank');
                            closeWindow(sharingWindow);
                        }
                    }

                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                }
            });

    });

    /**
     * Screen Share Individula click Event Handler
     */
    jQuery(document).on("click",".shareedesk",function(e){

            showloader();
            var shareid = jQuery(this).attr('data-id');
            /**
             * Ajax Call For Thread
             */
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: shareurl,
                type: 'POST',
                data: {
                    'shareids': shareid,
                    'viwer':'true'
                },
                success: function (data) {
                    showloader();
                    if(data.status === false){
                        showerrormessage(data.message);
                    } else {
                        if (data.presenterLink != '') {
                            var sharingWindow = window.open(data.presenterLink, '_blank');
                            closeWindow(sharingWindow);
                        }
                        // window.open(data.presenterLink,'_blank');
                    }
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                }
            });

    });

    /**
     * See the student Screen
     */
    jQuery(document).on("click",".takescreen",function(e){
        var takescreenid =  jQuery(this).attr('data-id');

            showloader();
            /**
             * Ajax Call For Thread
             */
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: shareurl,
                type: 'POST',
                data: {
                    'shareids': takescreenid,
                    'viwer':'false'
                },
                success: function (data) {
                    showloader();
                    if(data.status === false){
                        showerrormessage(data.message);
                    } else {
                        if(data.viewerLink != ''){
                            var sharingWindow = window.open(data.viewerLink,'_blank');
                            // closeWindow(sharingWindow);
                        }
                        //  window.open(data.viewerLink,'_blank');
                    }
                },
                error: function (data) {
                    showloader();
                    if (data.status === false) {
                        showerrormessage(data.message);
                    }
                }
            });

    });

    /**
     * Manage Edesk Click Event Handler
     */
    jQuery(document).on("click",".manageedesk",function(e){
         var studentid      = jQuery(this).attr('data-id');
         var studentclassid = jQuery(this).attr('data-class-id');
         var status         = jQuery(this).attr('data-status');
         var spanele        = jQuery(this).find('span');
         showloader();
         /**
          * Ajax Call For Thread
          */
         jQuery.ajax({
             headers: {
                 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
             },
             url: touchurl,
             type: 'POST',
             data: {
                 'studentid': studentid,
                 'studentclassid': studentclassid,
                 'status': status,
             },
             success: function (data) {
                 showloader();
                 if(data.status == true) {
                     spanele.html('');
                     if(data.active == 0){
                         spanele.html(managetouchoff);
                     } else {
                         spanele.html(managetouchon);
                     }
                 }
             },
             error: function (data) {
                 showloader();
                 if (data.status === false) {
                     showerrormessage(data.message);
                 }
             }
         });
         console.log(studentid);
     });
});


/**
 * Reset the selectbox value
 *
 */
function refreshAssignClassesBox(ids){
    jQuery("#"+ids).val('0');
    jQuery("#"+ids).selectpicker("refresh");
}


/**
 * Function for to validation add/edit form
 * @returns {boolean}
 *
 */
function validateform() {
    var $validate = true;

    if (jQuery("#first_name").val() == '') {
        $validate = false;
        jQuery("#first_name").parent().addClass('has-error');
    } else {
        jQuery("#first_name").parent().removeClass('has-error');
    }
    if (jQuery("#last_name").val() == '') {
        $validate = false;
        jQuery("#last_name").parent().addClass('has-error');
    } else {
        jQuery("#last_name").parent().removeClass('has-error');
    }
    if (jQuery("#email").val() == '') {
        $validate = false;
        jQuery("#email").parent().addClass('has-error');
    } else {
        jQuery("#email").parent().removeClass('has-error');
    }
    if (jQuery("#phone").val() == '') {
        $validate = false;
        jQuery("#phone").parent().addClass('has-error');
    } else {
        var phone = jQuery("#phone").val();
        var phone = phone.replace(/"/g, "").replace(/'/g, "").replace(/\(|\)/g, "").replace(/\s+/, "").replace('-', '');
        var pattern = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        if (pattern.test(phone) && phone.length === 10) {
            jQuery("#phone").parent().removeClass('has-error');
        }else {
            jQuery("#phone").parent().addClass('has-error');
            $validate = false;
        }
    }
    if (jQuery("#addressline1").val() == '') {
        $validate = false;
        jQuery("#addressline1").parent().addClass('has-error');
    } else {
        jQuery("#addressline1").parent().removeClass('has-error');
    }
    if (jQuery("#city").val() == '') {
        $validate = false;
        jQuery("#city").parent().addClass('has-error');
    } else {
        jQuery("#city").parent().removeClass('has-error');
    }
    if (jQuery("#postal_code").val() == '') {
        $validate = false;
        jQuery("#postal_code").parent().addClass('has-error');
    } else {
        jQuery("#postal_code").parent().removeClass('has-error');
    }

    return $validate;
}



/* Notification management tab click event handler
*
*/
jQuery("#notification-tab").click(function () {
    if (!$.fn.DataTable.isDataTable('#studentlist')) {
        showloader();
        showloader();
    }
});




/**
 * Ajax Call function which check how many sudents online in specific class
 * on running class
 * @param classid
 * @param checkurl
 */
function checkloggedInStudent(classid, checkurl) {

    jQuery.ajax({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        url: checkurl,
        type: 'POST',
        data: {
            'classid': classid
        },
        success: function (data) {
            if (data.status === true) {
                jQuery("#online_student").html('');
                jQuery("#online_student").html(data.online);
            } else {
                showerrormessage(data.message);
            }
        },
        error: function (data) {
            if (data.status === false) {
                showerrormessage(data.message);
            }
        }
    });
}


jQuery('#btn_back_list').click(function(){
    jQuery('#aineisto-tab').trigger('click');
});


