 <footer class="main-footer">
    <div class="pull-right hidden-xs">

    </div>
    <strong>Copyright &copy; <?php echo date('Y');?> Vidrio Oy.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->
 @if(!empty(Auth::user()->id))
 <div class="modal fade" id="admin-change-password" style="display: none;">
     <div class="modal-dialog">

         <form action="{{ url('/admin/changepassword') }}" method="post">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span></button>
                 <h4 class="modal-title">Change Password</h4>
             </div>
             <div class="modal-body">

                     {{ csrf_field() }}

                     <div class="form-group has-feedback">
                         <input type="password" class="form-control" placeholder="Current Password" id="currentpassword" name="currentpassword" autocomplete="off" />
                         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                     </div>

                     <div class="form-group has-feedback">
                         <input type="password" class="form-control" placeholder="New Password" id="newpassword" name="newpassword" autocomplete="off" />
                         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                     </div>

                     <div class="form-group has-feedback">
                         <input type="password" class="form-control" placeholder="Confirm New Password" id="cofnewpassword" name="cofnewpassword" autocomplete="off" />
                         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                     </div>



             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary" id="submit-change-pasword">Save</button>
             </div>
         </div>
         </form>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>

 <div class="modal" id="confirmDelete" data-id="">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span></button>
                     <h4 class="modal-title">Delete</h4>
             </div>
             <div class="modal-body">
                 <p>You are about to delete.</p>
                 <p>Do you want to proceed?</p>
             </div>
             <div class="modal-footer">
                 <a href="#" id="btnYes" class="btn btn-default">Yes</a>
                 <a href="#" data-dismiss="modal" aria-hidden="true" class="btn btn-default">No</a>
             </div>
         </div>
         <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
 </div>
 @endif

 <div class="loadmoreimg" style="display: none;"><img src="{{ asset('assests/images/loader.gif') }}"/> </div>

<!-- jQuery 3 -->
<script src="{{ asset('assests/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>

 <!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assests/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

 <!-- FastClick -->
<script src="{{ asset('assests/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>

 <!-- AdminLTE App -->
<script src="{{ asset('assests/admin/dist/js/adminlte.min.js') }}"></script>

 <!-- SlimScroll -->
<script src="{{ asset('assests/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

 @yield("page-js")

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assests/admin/dist/js/demo.js') }}"></script>

 <script src="{{ asset('assests/admin/admin-global.js') }}"></script>

</body>
</html>