
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Entry Date</th>
        <th>Day Of Week</th>
    </tr>
    <tbody>
        <?php foreach ($staffs as $staff) {
            $dayofweek = date('w', strtotime($staff->Created_at))
        ?>
            <tr>
                <td><?php echo $staff->StaffID; ?></td>
                <td class="utf8"><?php echo $staff->Name; ?></td>
                <td><?php echo $staff->Email; ?></td>
                <td><?php echo $staff->Created_at->format('d/m/Y'); ?></td>
                <td class="japanese"><?php echo $days[$dayofweek]; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
