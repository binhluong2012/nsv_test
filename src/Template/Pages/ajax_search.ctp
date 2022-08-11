<form id="resultForm" class="mt-4">
    <div class="form-row">
        <div class="col-2">
            <div class="form-group">
                <button type="button" onclick="backSearch()" class="btn btn-primary btn-block">BACK</button>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <a class="btn btn-secondary btn-info btn-block" href="/fileDownload">PDF</a>
            </div>
        </div>
        <div class="col-8">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button id="sendMailBtn" data-loading-text="Sending..." class="btn btn-success" type="button" onclick="sendMailForm();">Email</button>
                    </div>
                    <input type="email" id="email" class="form-control required email" style="height:38px;" name="email" placeholder="Email" />
                </div>

            </div>
        </div>
    </div>
</form>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Entry Date</th>
            <th>Day Of Week</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($staffs->count() > 0) {
            foreach ($staffs as $staff) {
                $dayofweek = date('w', strtotime($staff->Created_at))
        ?>
                <tr>
                    <td><?php echo $staff->StaffID; ?></td>
                    <td class="utf8"><?php echo $staff->Name; ?></td>
                    <td><?php echo $staff->Email; ?></td>
                    <td><?php echo $staff->Created_at->format('Y/m/d'); ?></td>
                    <td class="japanese"><?php echo $days[$dayofweek]; ?></td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="5" style="text-align:center">No results found</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
