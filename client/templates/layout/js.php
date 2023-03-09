<!-- Js Config -->
<script type="text/javascript">
    var NN_FRAMEWORK = NN_FRAMEWORK || {};
    var CONFIG_BASE = '<?= $configBase ?>';
    var JS_AUTOPLAY = <?= ($_SERVER["SERVER_NAME"] != "localhost") ? 'true' : 'false' ?>;
    var ASSETS = '<?= ASSETS ?>';
    var WEBSITE_NAME = '<?= (!empty($setting['name' . $lang])) ? addslashes($setting['name' . $lang]) : '' ?>';
    var TIMENOW = '<?= date("d/m/Y", time()) ?>';
    //var IS_LOGIN = <?= (isset($_SESSION[$loginMember]['active']) && $_SESSION[$loginMember]['active'] == true) ? 1 : 0 ?>;
</script>
<!-- Js Files -->
<script type="text/javascript" src="<?= $configBase ?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/lazyload.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/js/wow.min.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/bootstrap/bootstrap.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/holdon/HoldOn.js"></script>
<script type="text/javascript" src="<?= $configBase ?>assets/slick/slick.js"></script>
