<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Entry Date</th>
        <th>Day Of Week</th>
    </tr>
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
