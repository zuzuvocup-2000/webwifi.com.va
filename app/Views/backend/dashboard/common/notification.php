<?php  
    $session = session();
 //   $message = $session->getFlashdata('message-success');

    if(null !== show_flashdata()){
        $flash = show_flashdata();  
    }
?>

<?php if(isset($flash) && is_array($flash) && count($flash) && $flash['message'] != ''){ ?>
<script type="text/javascript">
    $(function () {
        var i = -1;
        var toastCount = 0;
        var $toastlast;
        var getMessage = function () {
            var msg = 'Hi, welcome to Inspinia. This is example of Toastr notification box.';
            return msg;
        };
        $('#showsimple').click(function (){
            // Display a success toast, with a title
            toastr.success('Without any options','Simple notification!')
        });
        $('#showtoast').click(function () {
            
        });
        var shortCutFunction = '<?php echo (isset($flash['flag']) && $flash['flag'] == 0) ? 'success' : 'error'; ?>';
        var msg = '<?php echo $flash['message']; ?>';
        var title = 'Thông báo từ hệ thống';
        var $showDuration = 400;
        var $hideDuration = 1000;
        var $timeOut = 7000;
        var $extendedTimeOut = 1000;
        var $showEasing = 'swing';
        var $hideEasing = 'linear';
        var $showMethod = 'fadeIn';
        var $hideMethod = 'fadeOut';
        var toastIndex = toastCount++;
        toastr.options = {
            closeButton: true,
            debug: false,
            progressBar: true,
            preventDuplicates: false,
            positionClass: 'toast-top-right',
            onclick: null
        };
        if ($('#addBehaviorOnToastClick').prop('checked')) {
            toastr.options.onclick = function () {
                alert('You can perform some custom action after a toast goes away');
            };
        }
        if ($showDuration.length) {
            toastr.options.showDuration = $showDuration;
        }
        if ($hideDuration.length) {
            toastr.options.hideDuration = $hideDuration;
        }
        if ($timeOut.length) {
            toastr.options.timeOut = $timeOut;
        }
        if ($extendedTimeOut.length) {
            toastr.options.extendedTimeOut = $extendedTimeOut;
        }
        if ($showEasing.length) {
            toastr.options.showEasing = $showEasing;
        }
        if ($hideEasing.length) {
            toastr.options.hideEasing = $hideEasing;
        }
        if ($showMethod.length) {
            toastr.options.showMethod = $showMethod;
        }
        if ($hideMethod.length) {
            toastr.options.hideMethod = $hideMethod;
        }
        if (!msg) {
            msg = getMessage();
        }
        $("#toastrOptions").text("Command: toastr["
                + shortCutFunction
                + "](\""
                + msg
                + (title ? "\", \"" + title : '')
                + "\")\n\ntoastr.options = "
                + JSON.stringify(toastr.options, null, 2)
        );
        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
        $toastlast = $toast;
        if ($toast.find('#okBtn').length) {
            $toast.delegate('#okBtn', 'click', function () {
                alert('you clicked me. i was toast #' + toastIndex + '. goodbye!');
                $toast.remove();
            });
        }
        if ($toast.find('#surpriseBtn').length) {
            $toast.delegate('#surpriseBtn', 'click', function () {
                alert('Surprise! you clicked me. i was toast #' + toastIndex + '. You could perform an action here.');
            });
        }
        
        function getLastToast(){
            return $toastlast;
        }
    })
</script>
<?php } ?>