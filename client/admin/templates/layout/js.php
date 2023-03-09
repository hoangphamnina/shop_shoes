<!-- Js Config -->
<script type="text/javascript">
    var PHP_VERSION = parseFloat('<?= phpversion() ?>'.replaceAll('.', ','));
    var CONFIG_BASE = '<?= $configBase ?>';
    var ADMIN = '<?= ADMIN ?>';
    var ASSET = '<?= ASSETS ?>';
    var LINK_FILTER = '<?= (!empty($linkFilter)) ? $linkFilter : '' ?>';
    var ID = <?= (!empty($id)) ? $id : 0 ?>;
    var COM = '<?= (!empty($com)) ? $com : '' ?>';
    var ACT = '<?= (!empty($act)) ? $act : '' ?>';
    var TYPE = '<?= (!empty($type)) ? $type : '' ?>';
    var MAX_DATE = '<?= date("Y/m/d", time()) ?>';
</script>

<!-- Js Files -->
<script src="assets/bootstrap/bootstrap.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/holdon/HoldOn.js"></script>
<script src="assets/js/adminlte.js"></script>
<script src="assets/daterangepicker/moment.min.js"></script>
<script src="assets/daterangepicker/daterangepicker.min.js"></script>
<script src="assets/datetimepicker/jquery.datetimepicker.min.js"></script>
<script src="assets/datetimepicker/jquery.mousewheel.js"></script>
<script src="assets/datetimepicker/php-date-formatter.min.js"></script>
<script src="assets/js/priceFormat.js"></script>
<script src="assets/js/apps.js"></script>