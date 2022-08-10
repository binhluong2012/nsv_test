<div class="row mt-4">
    <div class="col-md-10 offset-md-1">
        <form id="searchForm">
            <fieldset class="border p-2">
                <legend class="float-none w-auto p-2">From Entry Date</legend>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1">From</label>
                            <input type="number" class="form-control required" id="from" name="from" value="0" placeholder="Over or equal >=">
                        </div>
                        <div class="form-group">
                            <button type="button" onclick="searchForm()" class="btn btn-primary btn-block">SUBMIT</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1">To</label>
                            <input type="number" class="form-control comparison" id="to" name="to" placeholder="Under <">
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-secondary btn-block">CLEAR</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <div class="result">

        </div>

    </div>
</div>
<style type="text/css">
    table td, table th{
        border:1px solid #1798A5;
    }
</style>
<script type="text/javascript">
    var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;
    jQuery(document).ready(function() {
        $.validator.addMethod('comparison', function(val, element) {
            var pcompra = $("#from").val();
            return this.optional(element) || val >= pcompra;
        }, function(params, element) {
            return 'The field should empty or >= ' + $("#from").val();
        });

    });

    function searchForm() {
        if ($('#searchForm').valid()) {
            $.ajax({
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                url: '/ajaxSearch',
                dataType: 'html',
                type: 'post',
                data: $('#searchForm').serializeArray(),
                success: function(html, textStatus, jQxhr) {
                    $('#searchForm').hide();
                    $('.result').html(html);
                    $('#resultForm').validate({
                        errorPlacement: function(error, element) {
                            error.insertAfter(element.parent());
                        }
                    });
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

    }

    function backSearch() {
        $('.result').html('');
        $('#searchForm').show();
    }

    function sendMailForm() {
        if ($('#resultForm').valid()) {
            let btn = $('#sendMailBtn');
            let currentText = btn.html();
            let loadingText = btn.data('loading-text');
            $.ajax({
                headers: {
                    'X-CSRF-Token': csrfToken
                },
                url: '/sendMail',
                dataType: 'json',
                type: 'post',
                data: $('#resultForm').serializeArray(),
                beforeSend: function() {

                    btn.addClass('disabled');
                    btn.html(loadingText);
                },
                success: function(data, textStatus, jQxhr) {
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Email sent',
                            text: 'Please check your mail box'
                        })
                    }
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                complete: function() {
                    btn.removeClass('disabled');
                    btn.html(currentText);
                }
            });
        }
    }
</script>
