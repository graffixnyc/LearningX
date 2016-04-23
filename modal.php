<?php 
print_r($_POST);
if($_POST["data"]) {
echo '
    <div class="modal fade" id="myModal2">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="background:#28547a">
                '.$_POST["data"].'
                </h4>
              </div>
              <div class="modal-body">
              <h1>'.$_POST["data"].'</h1>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->';}
else {
    echo "wrong";
}

?>

